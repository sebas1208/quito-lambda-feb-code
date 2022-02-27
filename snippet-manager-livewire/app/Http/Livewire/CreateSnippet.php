<?php

namespace App\Http\Livewire;

use App\Models\Snippets\Language;
use Livewire\Component;
use App\Models\Snippets\Snippet;

class CreateSnippet extends Component
{
    public Snippet $snippet;
    public array $languages = [];
    public string $tag = "";

    protected $rules = [
        'snippet.title' => 'required|string|max:100|min:4',
        'snippet.language' => 'required|string|max:20',
        'snippet.code' => 'required|string|min:10',
        'snippet.tags' => 'array',
    ];

    public $listeners = ['textAreaUpdated'];

    public function mount()
    {
        $this->languages = collect(Language::cases())
            ->map(fn (Language $ln) => $ln->label())
            ->toArray();

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
        $this->validateOnly('snippet.code');
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

        $this->snippet->language = Language::fromLabel($this->snippet->language)->name;
        $this->snippet->save();

        return redirect('create-snippet')->with('message', 'Snippet successfully created.');
    }
}
