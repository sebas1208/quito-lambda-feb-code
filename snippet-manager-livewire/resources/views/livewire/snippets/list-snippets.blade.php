<div class="container mx-auto px-6 py-6 max-w-7xl">
    <section class="pt-10 pb-10 lg:pb-20 bg-[#F3F4F6]">
        <div class="mt-5 mb-5 md:mt-0 md:col-span-2">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <div class="grid grid-cols-3">
                        <div>
                            <p class="block text-lg font-bold text-gray-700">
                                Filters
                            </p>
                            <div class="mt-1 mb-2 rounded-md">
                                <span>Tag:</span>
                            </div>
                            <input wire:model.debounce.500="filterTag" class="rounded-md border-gray-300" type="text"
                                placeholder="Search by tags ">
                        </div>
                        <div>
                            <div class="mt-7 mb-2 rounded-md">
                                <span>Language:</span>
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
        <div class="flex flex-wrap -mx-4">
            {{-- TODO: show a message when no snippets filtered --}}
            @forelse ($snippets as $snippet)
                <div class="w-full md:w-1/2 xl:w-full px-4">
                    <div class="bg-white rounded-lg overflow-hidden mb-10">
                        <div class="p-8 sm:p-9 md:p-7 xl:p-9 text-xl text-gray-700">
                            <p class="font-bold">
                                Title: <span class="font-light">{{ $snippet->title }}</span>
                            </p>
                            <p class="font-bold mb-4">
                                Language: <span class="font-light">{{ $snippet->language }}</span>
                            </p>
                            <div class="mb-4 text-base">
                                <textarea wire:model="snippet.code" name="code" id="code-{{ $loop->index }}" cols="10"
                                    rows="5"></textarea>
                            </div>
                            <p class="font-bold">Tags:</p>
                            @foreach ($snippet->tags as $tag)
                                <div wire:key="{{ $loop->index }}"
                                    class="bg-blue-100 inline-flex items-center text-sm rounded mt-2 mr-1 overflow-hidden">
                                    <span
                                        class="ml-2 mr-1 leading-relaxed truncate max-w-xs px-1">{{ $tag }}</span>
                                    <button
                                        class="w-6 h-8 inline-block align-middle text-gray-500 bg-blue-200 focus:outline-none"
                                        type="button">
                                        <svg class="w-6 h-6 fill-current mx-auto" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M15.78 14.36a1 1 0 0 1-1.42 1.42l-2.82-2.83-2.83 2.83a1 1 0 1 1-1.42-1.42l2.83-2.82L7.3 8.7a1 1 0 0 1 1.42-1.42l2.83 2.83 2.82-2.83a1 1 0 0 1 1.42 1.42l-2.83 2.83 2.83 2.82z" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="w-full md:w-1/2 xl:w-full px-4 text-center text-bold">
                    <div class="bg-white rounded-lg overflow-hidden mb-10 h-12 pt-2">
                        <span class="ml-6">No Snippets for this filter
                            <a class="underline text-blue-500" href="{{ route('create-snippet') }}">Create one</a>
                        </span>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    @push('scripts')
        <script>
            const languageMap = {
                PHP: "php",
                Javascript: "javascript",
                Java: "clike",
                "C#": "clike",
                Haskell: "haskell"
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
                initCodeMirror(`{!! $snippet->code !!}`, `{{ $snippet->language }}`, {{ $loop->index }});
            @endforeach

            Livewire.on("reloadCodeMirror", (snippets = []) => {
                console.log(snippets);
                snippets.forEach((snippet, index) => initCodeMirror(snippet.code, snippet.language, index))
            });
        </script>
    @endpush
</div>
