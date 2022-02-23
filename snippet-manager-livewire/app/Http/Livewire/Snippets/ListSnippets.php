<?php

namespace App\Http\Livewire\Snippets;

use App\Models\Snippets\Language;
use App\Models\Snippets\Snippet;
use Illuminate\Support\Collection;
use Livewire\Component;

class ListSnippets extends Component
{
    public Collection $snippets;
    public string $filterTag = '';
    public string $filterLanguage = '';
    public array $languages = [];

    protected $queryString = [
        'filterTag' => ['except' => ''],
        'filterLanguage' => ['except' => ''],
    ];


    public function mount()
    {
        $this->languages = collect(Language::cases())
            ->map(fn (Language $ln) => $ln->label())
            ->toArray();

        if ($this->filterTag) {
            $this->filterBy(
                'filterTag',
                fn (Snippet $snippet) => in_array($this->filterTag, $snippet->tags)
            );

            return;
        }

        if ($this->filterLanguage) {
            $this->filterBy(
                'filterLanguage',
                fn (Snippet $snippet) => $snippet->language === $this->filterLanguage
            );

            return;
        }

        $this->snippets = Snippet::all();
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
            fn (Snippet $snippet) => $snippet->language === Language::from($this->filterLanguage)->name
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

    public function render()
    {
        return view('livewire.snippets.list-snippets');
    }
}
