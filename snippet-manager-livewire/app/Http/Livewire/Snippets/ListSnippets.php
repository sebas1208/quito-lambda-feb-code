<?php

namespace App\Http\Livewire\Snippets;

use App\Models\Snippets\Snippet;
use Illuminate\Support\Collection;
use Livewire\Component;

class ListSnippets extends Component
{
    public Collection $snippets;
    public string $filterTag = '';
    public string $filterLanguage = '';
    public array $languages = ['PHP', 'Javascript', 'Java', 'C#', 'Haskell'];

    protected $queryString = [
        'filterTag' => ['except' => ''],
        'filterLanguage' => ['except' => ''],
    ];


    public function mount()
    {
        if($this->filterTag) {
            $this->filterBy(
                'filterTag',
                fn (Snippet $snippet) => in_array($this->filterTag, $snippet->tags)
            );
        }

        if($this->filterLanguage) {
            $this->filterBy(
                'filterLanguage',
                fn (Snippet $snippet) => $snippet->language === $this->filterLanguage
            );
        }
    }

    public function render()
    {
        return view('livewire.snippets.list-snippets');
    }

    public function updatedFilterTag()
    {
        $this->filterBy(
            'filterTag',
            fn (Snippet $snippet) => in_array($this->filterTag, $snippet->tags)
        );
    }

    public function updatedFilterLanguage()
    {
        $this->filterBy(
            'filterLanguage',
            fn (Snippet $snippet) => $snippet->language === $this->filterLanguage
        );
    }

    private function filterBy(string $property, callable $filter)
    {
        if ($this->{$property} === '') {
            $this->snippets = Snippet::all();
            $this->emit('reloadCodeMirror', $this->snippets);
            return;
        }

        $this->snippets = Snippet::all()->filter($filter)->values();

        $this->emit('reloadCodeMirror', $this->snippets);
    }
}
