<div class="space-y-4">
    <ul role="list" class="space-y-4">
        @if (filled($previousPost))
            <li class="relative flex gap-x-4">
                <div class="absolute top-0 -bottom-6 left-0 flex w-6 justify-center">
                    <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                </div>

                <div class="relative flex size-6 flex-none items-center justify-center bg-white dark:bg-gray-950">
                    <div
                        class="size-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300 dark:bg-gray-800 dark:ring-gray-600"
                    ></div>
                </div>

                <div class="flex flex-auto flex-col py-0.5 text-xs/5 text-gray-500 dark:text-gray-400">
                    <p class="font-medium text-gray-950 dark:text-white">{{ $this->getTitle($previousPost) }}</p>
                    <p class="italic">{{ $this->getLocationDayTime($previousPost) }}</p>
                </div>
            </li>
        @endif

        <li class="relative flex gap-x-4">
            @if (filled($nextPost))
                <div class="absolute top-0 -bottom-6 left-0 flex w-6 justify-center">
                    <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                </div>
            @endif

            <div class="relative flex size-6 flex-none items-center justify-center bg-white dark:bg-gray-950">
                <div
                    class="bg-primary-100 ring-primary-300 dark:bg-primary-950 dark:ring-primary-800 size-1.5 rounded-full ring-1"
                ></div>
            </div>

            <div class="flex flex-auto flex-col py-0.5 text-xs/5 text-gray-500 dark:text-gray-400">
                <p class="font-medium text-gray-950 dark:text-white">{{ $this->getTitle() }}</p>
                <p class="italic">{{ $this->getLocationDayTime() }}</p>
            </div>
        </li>

        @if (filled($nextPost))
            <li class="relative flex gap-x-4">
                <div class="relative flex size-6 flex-none items-center justify-center bg-white dark:bg-gray-950">
                    <div
                        class="size-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300 dark:bg-gray-800 dark:ring-gray-600"
                    ></div>
                </div>

                <div class="flex flex-auto flex-col py-0.5 text-xs/5 text-gray-500 dark:text-gray-400">
                    <p class="font-medium text-gray-950 dark:text-white">{{ $this->getTitle($nextPost) }}</p>
                    <p class="italic">{{ $this->getLocationDayTime($nextPost) }}</p>
                </div>
            </li>
        @endif
    </ul>

    <x-button
        wire:click="$dispatch('slide-over.open', {
            component: 'posts-position-editor',
            arguments: {
                'postId': {{ $postId }},
                'previousId': {{ Js::from($previousPost?->id) }},
                'nextId': {{ Js::from($nextPost?->id) }}
            }
        })"
        variant="ghost"
    >
        Update position
        <span aria-hidden="true">→</span>
    </x-button>
</div>
