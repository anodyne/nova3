<div>
    <x-content-box>
        <x-page-header :pretitle="$post->story->title">
            {{ $post->title }}
        </x-page-header>

        <div class="flex items-center space-x-6">
            <div class="flex items-center space-x-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                <x-icon name="location" size="md" class="shrink-0 text-gray-400 dark:text-gray-500"></x-icon>
                <span>{{ $post->location }}</span>
            </div>

            <div class="flex items-center space-x-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                <x-icon name="calendar" size="md" class="shrink-0 text-gray-400 dark:text-gray-500"></x-icon>
                <span>{{ $post->day }}</span>
            </div>

            <div class="flex items-center space-x-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                <x-icon name="clock" size="md" class="shrink-0 text-gray-400 dark:text-gray-500"></x-icon>
                <span>{{ $post->time }}</span>
            </div>
        </div>

        <div class="mt-4 flex items-center space-x-2 text-sm font-medium text-gray-500 dark:text-gray-400">
            <x-icon name="users" size="md" class="shrink-0 text-gray-400 dark:text-gray-500"></x-icon>
            <span>Captain Jean-Luc Picard, Commander William Riker, and Dr. Beverly Crusher</span>
        </div>

        <hr class="mx-auto mt-8 w-full max-w-xl border-gray-200 dark:border-gray-700" />

        <div class="prose mt-8 max-w-none dark:prose-invert">
            {!! $post->content !!}
        </div>
    </x-content-box>

    <x-content-box
        class="z-20 rounded-b-lg bg-gray-50 dark:bg-gray-700/50 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse"
        height="sm"
        width="sm"
    >
        <x-button.filled color="gray" wire:click="dismiss">Close</x-button.filled>
    </x-content-box>
</div>
