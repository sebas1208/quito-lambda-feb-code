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
        <div class="mt-5 md:mt-0 md:col-span-2 shadow-2xl bg-white rounded-xl">
            <div class="">
                <form wire:submit.prevent="save" novalidate onkeydown="return event.key != 'Enter';">
                    <div class="px-4 py-5 space-y-6 sm:p-6">
                        <div>
                            <label for="title" class="font-bold text-gray-700">
                                Title
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="title" class="w-full rounded-md border-gray-300"
                                    wire:model.debounce.500="snippet.title" type="text" placeholder="Enter your title">
                            </div>
                            <div class="m-2">
                                @error('snippet.title')
                                    <span class="text-pink-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="language" class="font-bold text-gray-700">
                                Language
                            </label>
                            <div class="mt-1 rounded-md">
                                <select wire:change="changeLanguageMode" wire:model="snippet.language"
                                    class="w-full md:w-1/2 rounded-md border-gray-300 text-gray-600" name="language"
                                    id="language">
                                    <option value class="text-gray-700">Select the Language</option>
                                    @foreach ($languages as $language)
                                        <option wire:key="{{ $loop->index }}">{{ $language }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="m-2">
                                @error('snippet.language')
                                    <span class="text-pink-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="code" class="font-bold text-gray-700">
                                Code
                            </label>
                            <div class="mt-1" wire:ignore>
                                <textarea wire:model="snippet.code" id="code" name="code" rows="10"></textarea>
                            </div>
                            <div class="m-2">
                                @error('snippet.code')
                                    <span class="text-pink-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="tags" class="text-sm font-bold text-gray-700">
                                Tags
                            </label>
                            <div class="mt-2">
                                <input wire:keydown.enter="addTag" wire:model="tag" class="rounded-md border-gray-300"
                                    type="text" placeholder="Enter your tags">
                            </div>
                            <div class="mt-2">
                                @foreach ($snippet->tags as $tag)
                                    <div wire:key="{{ $tag . strval($loop->index) }}"
                                        class="bg-blue-200 inline-flex items-center text-sm rounded">
                                        <span
                                            class="ml-2 mr-1 leading-relaxed truncate max-w-xs px-1">{{ $tag }}</span>
                                        <button
                                            class="rounded-r w-6 h-8 align-middle text-stone-700 bg-blue-300 hover:bg-amber-300"
                                            type="button" wire:click="removeTag({{ $loop->index }})">
                                            <span class="font-black">x</span>
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
                    <div class="px-4 py-3 bg-gray-50 text-right rounded-b-xl">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 shadow-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Save</button>
                    </div>
                </form>
            </div>
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

        const initCodeMirror = () => {
            const textArea = document.getElementById("code");
            const editor = CodeMirror.fromTextArea(textArea, {
                lineNumbers: true,
                theme: "gruvbox-dark",
                matchBrackets: true,
                indentUnit: 2,
                tabSize: 2,
            });

            editor.on('change', (editor) => {
                textArea.value = editor.getValue();
                @this.emit('textAreaUpdated', textArea.value);
            });

            Livewire.on("changeEditorMode", (language) => {
                editor.setOption('mode', languageMap[language])
            });
        }

        initCodeMirror();
    </script>
@endpush
