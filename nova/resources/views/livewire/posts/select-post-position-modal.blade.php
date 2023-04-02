<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            @icon('book', 'h-6 w-6 shrink-0 text-gray-600 dark:text-gray-500')
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Set post position</h3>
        </div>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div>
            <x-input.group>
                <x-input.text placeholder="Search posts" wire:model.debounce.500ms="search" autofocus>
                    <x-slot:leadingAddOn>
                        @icon('search')
                    </x-slot:leadingAddOn>

                    <x-slot:trailingAddOn>
                        @if ($search)
                            <x-link tag="button" color="gray" wire:click="$set('search', '')">
                                @icon('close', 'h-5 w-5')
                            </x-link>
                        @endif
                    </x-slot:trailingAddOn>
                </x-input.text>
            </x-input.group>

            <div class="mt-4 w-full max-h-60 h-60 overflow-auto bg-white dark:bg-gray-800 text-base focus:outline-none sm:text-sm" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="space-y-1">
                    @if ($posts->count() > 0)
                        @foreach ($posts as $post)
                            <div class="p-1.5 rounded-md odd:bg-gray-50 dark:odd:bg-gray-700/50">
                                <a role="button" class="flex items-center w-full space-x-2" wire:click="selectPost({{ $post }})">
                                    <span style="color:{{ $post->postType->color }}">
                                        @icon($post->postType->icon, 'h-5 w-5')
                                    </span>
                                    <span>{{ $post->title }}</span>
                                </a>

                                @if ($selected === $post->id)
                                    <div class="mt-2 ml-7 space-x-1.5">
                                        <x-button :color="$direction === 'before' ? 'primary' : 'white'" size="xs" wire:click="beforePost">Before this post</x-button>
                                        <x-button :color="$direction === 'after' ? 'primary' : 'white'" size="xs" wire:click="afterPost">After this post</x-button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-50 dark:bg-gray-700/50 rounded-b-lg" height="sm" width="sm">
        @if ($selected && $direction)
            <x-button color="primary" wire:click="apply">Apply</x-button>
        @endif

        <x-button color="white" wire:click="dismiss">Cancel</x-button>
    </x-content-box>
</div>
