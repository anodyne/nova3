<div>
    <header class="relative shadow bg-white mb-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-3 | sm:px-6 md:px-8">
            <div class="flex flex-col">
                Leading
            </div>

            <div class="flex items-center space-x-4">
                Trailing
            </div>
        </div>
    </header>

    <main class="w-full max-w-7xl mx-auto px-4 | sm:px-6 md:px-8">
        <div class="grid gap-8 | lg:grid-cols-4">
            <div class="lg:col-span-3">
                <div class="w-full mb-8">
                    @if ($stories->count() === 1)
                        <p class="text-base font-medium text-gray-500 mb-2">{{ $stories->first()->title }}</p>
                    @endif

                    @if ($stories->count() > 1)
                        <p class="text-base font-medium text-gray-500 mb-2">{{ $stories->first()->title }}</p>
                    @endif

                    @if ($postType->fields->title)
                        <x-input.group>
                            <input type="text" class="w-full bg-transparent appearance-none focus:outline-none text-3xl font-extrabold text-gray-900 tracking-tight placeholder-gray-400 | sm:text-4xl md:text-5xl" placeholder="Title here">
                        </x-input.group>
                    @endif

                    @if ($postType->fields->time || $postType->fields->day || $postType->fields->location)
                        <div class="flex flex-col space-y-8 text-gray-600 text-lg font-medium mt-8 | md:mt-4 md:flex-row md:items-center md:space-x-8 md:space-y-0">
                            @if ($postType->fields->day)
                                <div class="group flex items-center w-full space-x-2">
                                    @icon('calendar', 'h-5 w-5 text-gray-400 group-focus-within:text-gray-600')
                                    <input type="text" class="w-full bg-transparent appearance-none focus:outline-none text-base font-medium text-gray-700 placeholder-gray-400" placeholder="Add a day">
                                </div>
                            @endif

                            @if ($postType->fields->time)
                                <div class="group flex items-center w-full space-x-2">
                                    @icon('clock', 'h-5 w-5 text-gray-400 group-focus-within:text-gray-600')
                                    <input type="text" class="w-full bg-transparent appearance-none focus:outline-none text-base font-medium text-gray-700 placeholder-gray-400" placeholder="Add a time">
                                </div>
                            @endif

                            @if ($postType->fields->location)
                            <div class="group flex items-center w-full space-x-2">
                                    @icon('location', 'h-5 w-5 text-gray-400 group-focus-within:text-gray-600')
                                    <input type="text" class="w-full bg-transparent appearance-none focus:outline-none text-base font-medium text-gray-700 placeholder-gray-400" placeholder="Add a location">
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @if ($postType->fields->content)
                <x-input.group>
                    {{-- <x-input.rich-text name="content" :initial-value="old('content')" /> --}}
                    <x-input.editor-minimal>{{ old('content') }}</x-input.editor-minimal>
                </x-input.group>
                @endif
            </div>

            <div class="space-y-8">
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-wide font-semibold text-gray-500">Your characters</span>
                    Select your characters
                </div>

                @if ($postType->options->multipleAuthors)
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-wide font-semibold text-gray-500">Other characters</span>
                    Add more characters
                </div>

                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-wide font-semibold text-gray-500">Other contributors</span>
                    Add other contributors
                </div>
                @endif
            </div>
        </div>
    </main>
</div>