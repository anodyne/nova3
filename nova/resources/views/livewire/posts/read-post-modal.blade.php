<div>
    <x-content-box>
        <x-page-header :pretitle="$post->story->title">
            {{ $post->title }}
        </x-page-header>

        <div class="flex items-center space-x-6">
            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                <x-icon name="location" size="md" class="text-gray-400 dark:text-gray-500 shrink-0"></x-icon>
                <span>{{ $post->location }}</span>
            </div>

            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                <x-icon name="calendar" size="md" class="text-gray-400 dark:text-gray-500 shrink-0"></x-icon>
                <span>{{ $post->day }}</span>
            </div>

            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                <x-icon name="clock" size="md" class="text-gray-400 dark:text-gray-500 shrink-0"></x-icon>
                <span>{{ $post->time }}</span>
            </div>
        </div>

        <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 font-medium mt-4">
            <x-icon name="users" size="md" class="text-gray-400 dark:text-gray-500 shrink-0"></x-icon>
            <span>Captain Jean-Luc Picard, Commander William Riker, and Dr. Beverly Crusher</span>
        </div>

        <hr class="w-full max-w-xl mt-8 border-gray-200 dark:border-gray-700 mx-auto">

        <div class="prose dark:prose-invert max-w-none mt-8">
            {!! $post->content !!}
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-50 dark:bg-gray-700/50 rounded-b-lg" height="sm" width="sm">
        <x-button.outline color="gray" wire:click="dismiss">Close</x-button.outline>
    </x-content-box>
</div>
