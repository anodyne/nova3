<div>
    <x-spacing width="sm">
        <div class="flex items-center space-x-2">
            <x-icon name="book" size="md" class="shrink-0 text-gray-600 dark:text-gray-500"></x-icon>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Set post position</h3>
        </div>
    </x-spacing>

    <x-spacing height="none" width="sm">
        <div>
            <x-fieldset.field>
                <x-input.text placeholder="Search posts" wire:model.live.debounce.500ms="search" autofocus>
                    <x-slot name="leading">
                        <x-icon name="search" size="sm"></x-icon>
                    </x-slot>

                    <x-slot name="trailing">
                        @if ($search)
                            <x-button tag="button" color="neutral" wire:click="$set('search', '')" text>
                                <x-icon name="x" size="sm"></x-icon>
                            </x-button>
                        @endif
                    </x-slot>
                </x-input.text>
            </x-fieldset.field>

            <div class="mt-4 w-full max-h-60 h-60 overflow-auto bg-white dark:bg-gray-800 text-base focus:outline-none sm:text-sm" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="space-y-1">
                    @if ($posts->count() > 0)
                        @foreach ($posts as $post)
                            <div class="p-1.5 rounded-md odd:bg-gray-50 dark:odd:bg-gray-700/50">
                                <a role="button" class="flex items-center w-full space-x-2" wire:click="selectPost({{ $post }})">
                                    <span style="color:{{ $post->postType->color }}">
                                        <x-icon :name="$post->postType->icon" size="sm"></x-icon>
                                    </span>
                                    <span>{{ $post->title }}</span>
                                </a>

                                @if ($selected === $post->id)
                                    <div class="mt-2 ml-7 space-x-1.5">
                                        <x-button :color="$direction === 'before' ? 'primary' : 'neutral'" size="xs" wire:click="beforePost">Before this post</x-button>
                                        <x-button<x-icon name="edit" size="sm"></x-icon> :color="$direction === 'after' ? 'primary' : 'neutral'" size="xs" wire:click="afterPost">After this post</x-button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
    </x-spacing>

    <x-spacing class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-50 dark:bg-gray-700/50 rounded-b-lg" size="sm">
        @if ($selected && $direction)
            <x-button color="primary" wire:click="apply">Apply</x-button>
        @endif

        <x-button wire:click="dismiss" plain>Cancel</x-button>
    </x-spacing>
</div>
