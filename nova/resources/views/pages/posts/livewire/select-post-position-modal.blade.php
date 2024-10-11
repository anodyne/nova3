<x-modal title="Set post position" icon="book">
    <x-spacing>
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

            <div
                class="mt-4 h-60 max-h-60 w-full overflow-auto bg-white text-base focus:outline-none dark:bg-gray-800 sm:text-sm"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="menu-button"
                tabindex="-1"
            >
                <div class="space-y-1">
                    @if ($posts->count() > 0)
                        @foreach ($posts as $post)
                            <div class="rounded-md p-1.5 odd:bg-gray-50 dark:odd:bg-gray-700/50">
                                <a
                                    role="button"
                                    class="flex w-full items-center space-x-2"
                                    wire:click="selectPost({{ $post }})"
                                >
                                    <span style="color: {{ $post->postType->color }}">
                                        <x-icon :name="$post->postType->icon" size="sm"></x-icon>
                                    </span>
                                    <span>{{ $post->title }}</span>
                                </a>

                                @if ($selected === $post->id)
                                    <div class="ml-7 mt-2 space-x-1.5">
                                        <x-button
                                            :color="$direction === 'before' ? 'primary' : 'neutral'"
                                            size="xs"
                                            wire:click="beforePost"
                                        >
                                            Before this post
                                        </x-button>
                                        <x-button
                                            :color="$direction === 'after' ? 'primary' : 'neutral'"
                                            size="xs"
                                            wire:click="afterPost"
                                        >
                                            After this post
                                        </x-button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </x-spacing>

    <x-spacing class="z-20 rounded-b-lg sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse">
        @if ($selected && $direction)
            <x-button color="primary" wire:click="apply">Apply</x-button>
        @endif

        <x-button wire:click="dismiss" plain>Cancel</x-button>
    </x-spacing>
</x-modal>
