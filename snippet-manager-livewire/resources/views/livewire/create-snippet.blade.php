<div>
    <div class="container mx-auto px-6 py-6 max-w-7xl">
        @if (session()->has('message'))
            <div class="border-lime-500 border-2 text-lime-500 text-lg w-full text-center bg-stone-100 rounded-md mb-4 h-12">
                <span class="align-sub">{{ session('message') }}</span>
            </div>
        @endif
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Create Snippet</h3>
                    <p class="mt-1 text-sm text-gray-600">Fill the data to create your Snippet</p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form wire:submit.prevent="save" novalidate onkeydown="return event.key != 'Enter';">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-1">
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="Title" class="block text-sm font-bold text-gray-700">
                                        Title
                                    </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input class="w-full rounded-md border-gray-300" wire:model="snippet.title"
                                            type="text" placeholder="Enter your title">
                                    </div>
                                    <div class="m-2">
                                        @error('snippet.title')
                                            <span class="text-pink-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="language" class="block text-sm font-bold text-gray-700">
                                        Language
                                    </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <select wire:change="changeLanguageMode" wire:model="snippet.language"
                                            class="rounded-md block flex-1 border-gray-300" name="language"
                                            id="language">
                                            <option value class="text-gray-700">Select the Language</option>
                                            @foreach ($languages as $_language)
                                                <option wire:key="{{ $loop->index }}">{{ $_language }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="m-2">
                                        @error('snippet.language')
                                            <span class="text-pink-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="about" class="block text-sm font-medium text-gray-700"> Code </label>
                                <div class="mt-1" wire:ignore>
                                    <textarea wire:key="code" wire:model="snippet.code" class="rounded-md" id="code"
                                        name="code" rows="10"></textarea>
                                </div>
                                <div class="m-2">
                                    @error('snippet.code')
                                        <span class="text-pink-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 pb-1"> Tags </label>
                                <input wire:keydown.enter="addTag" wire:model="tag" class="rounded-md border-gray-300"
                                    type="text" placeholder="Enter your tags">
                                <div>
                                    @foreach ($snippet->tags as $tag)
                                        <div wire:key="{{ $loop->index }}"
                                            class="bg-blue-100 inline-flex items-center text-sm rounded mt-2 mr-1 overflow-hidden">
                                            <span
                                                class="ml-2 mr-1 leading-relaxed truncate max-w-xs px-1">{{ $tag }}</span>
                                            <button
                                                class="w-6 h-8 inline-block align-middle text-gray-500 bg-blue-200 focus:outline-none"
                                                type="button" wire:click="removeTag({{ $loop->index }})">
                                                <svg class="w-6 h-6 fill-current mx-auto"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M15.78 14.36a1 1 0 0 1-1.42 1.42l-2.82-2.83-2.83 2.83a1 1 0 1 1-1.42-1.42l2.83-2.82L7.3 8.7a1 1 0 0 1 1.42-1.42l2.83 2.83 2.82-2.83a1 1 0 0 1 1.42 1.42l-2.83 2.83 2.83 2.82z" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                    <div class="m-2">
                                        @error('snippet.tags')
                                            <span class="text-pink-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const languageMap = {
                PHP: "php",
                Javascript: "javascript",
                Java: "clike",
                "C#": "clike",
                Haskell: "haskell"
            };

            const textArea = document.getElementById("code");
            const editor = CodeMirror.fromTextArea(textArea, {
                lineNumbers: true,
                theme: "gruvbox-dark",
                matchBrackets: true,
                mode: 'php',
                indentUnit: 4,
                indentWithTabs: true,
                tabSize: 4,
                lineWrapping: true,
            });

            editor.on('change', (editor) => {
                textArea.value = editor.getValue();
                textArea.dispatchEvent(new Event('change'));
                @this.emit('textAreaUpdated', textArea.value);
            });

            Livewire.on("changeEditorMode", (language) => {
                editor.setOption('mode', languageMap[language])
            });
        </script>
    @endpush
</div>
