<div class="container mx-auto px-6 py-6 max-w-7xl">
    <section class="pt-2 pb-4 bg-[#F3F4F6]">
        <div class="mb-5">
            <div class="shadow-lg rounded-md overflow-hidden">
                <div class="px-4 py-4 bg-white">
                    <p class="block text-lg font-bold text-gray-600">
                        Filters
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3">
                        <div>
                            <div class="mt-1 mb-2">
                                Tag:
                            </div>
                            <input wire:model.debounce.500="filterTag" class="rounded-md border-gray-300" type="text"
                                placeholder="Search by tags ">
                        </div>
                        <div>
                            <div class="mt-1 mb-2 rounded-md">
                                Language:
                            </div>
                            <select wire:model="filterLanguage" class="rounded-md block flex-1 border-gray-300"
                                name="language" id="language">
                                <option value>All</option>
                                @foreach ($languages as $_language)
                                    <option wire:key="{{ $loop->index }}">{{ $_language }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
        @forelse ($snippets as $snippet)
            <div class="bg-white rounded-lg shadow-xl">
                <div class="p-8 text-md text-gray-600">
                    <p class="font-bold">
                        Title: <span class="font-light">{{ $snippet->title }}</span>
                    </p>
                    <p class="font-bold mb-4">
                        Language: <span class="font-light">{{ $snippet->getLanguageLabel() }}</span>
                    </p>
                    <div class="mb-4">
                        <textarea wire:model="snippet.code" name="code" id="code-{{ $loop->index }}" cols="10"
                            rows="5"></textarea>
                    </div>
                    <p class="font-bold">Tags:</p>
                    @foreach ($snippet->tags as $tag)
                        <div wire:key="{{ $loop->index }}"
                            class="bg-blue-200 inline-flex text-sm rounded mt-2 mr-1">
                            <span class="mx-1 px-1">{{ $tag }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="w-full md:w-1/2 xl:w-full px-4 text-center text-bold">
                <div class="bg-white rounded-lg mb-10 h-12 pt-2">
                    <span class="ml-6">No Snippets for this filter
                        <a class="underline text-blue-500" href="{{ route('create-snippet') }}">Create one</a>
                    </span>
                </div>
            </div>
        @endforelse
    </div>


    @push('scripts')
        <script>
            const languageMap = {
                PHP: "php",
                JS: "javascript",
                JAVA: "clike",
                CSHARP: "clike",
                HASKELL: "haskell"
            };

            const initCodeMirror = (code, language, index) => {
                const textArea = document.getElementById(`code-${index}`);
                textArea.value = code;
                const editor = CodeMirror.fromTextArea(textArea, {
                    lineNumbers: true,
                    theme: "gruvbox-dark",
                    matchBrackets: true,
                    mode: languageMap[language],
                    indentUnit: 2,
                    tabSize: 2,
                    gutter: true
                });
                textArea.dataset.editor = editor;
            };

            @foreach ($snippets as $snippet)
                initCodeMirror(@json($snippet->code), @json($snippet->language), {{ $loop->index }});
            @endforeach

            Livewire.on("reloadCodeMirror", (snippets = []) => {
                snippets.forEach((snippet, index) => initCodeMirror(snippet.code, snippet.language, index))
            });
        </script>
    @endpush
</div>
