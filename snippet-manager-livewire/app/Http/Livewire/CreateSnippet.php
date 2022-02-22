<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Snippets\Snippet;

class CreateSnippet extends Component
{
    public Snippet $snippet;
    public array $languages = ['PHP', 'Javascript', 'Java', "C#", "Haskell"];
    public string $tag = "";

    protected $rules = [
        'snippet.title' => 'required|string|max:100|min:4',
        'snippet.language' => 'required|string|max:20',
        'snippet.code' => 'required|string',
        'snippet.tags' => 'array',
    ];

    public $listeners = ['textAreaUpdated'];

    public function mount()
    {
        $this->snippet = new Snippet();
        $this->snippet->language = "";
        $this->snippet->tags = [];
    }

    public function changeLanguageMode()
    {
        $this->emit('changeEditorMode', $this->snippet->language);
    }

    public function render()
    {
        return view('livewire.create-snippet');
    }

    public function textAreaUpdated(string $code)
    {
        $this->snippet->code = $code;
        $this->validate();
    }

    public function addTag()
    {
        if (!$this->tag) return;

        $this->snippet->tags = [...$this->snippet->tags, $this->tag];
        $this->tag = '';
    }

    public function removeTag(int $index)
    {
        $tags = $this->snippet->tags;
        $this->snippet->tags = [
            ...array_slice($tags, 0, $index),
            ...array_slice($tags, $index + 1)
        ];
    }

    public function updated(string $property)
    {
        $this->validateOnly($property);
    }

    public function save()
    {
        $this->validate();
        $this->snippet->save();

        return redirect('create-snippet')->with('message', 'Snippet successfully created.');
    }
}
