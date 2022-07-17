<div>
    <x-content-box>
        <x-page-header :pretitle="$post->story->title">
            {{ $post->title }}
        </x-page-header>

        <div class="flex items-center space-x-6">
            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                @icon('location', 'h-6 w-6 text-gray-400 dark:text-gray-500 shrink-0')
                <span>{{ $post->location }}</span>
            </div>

            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                @icon('calendar', 'h-6 w-6 text-gray-400 dark:text-gray-500 shrink-0')
                <span>{{ $post->day }}</span>
            </div>

            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                @icon('clock', 'h-6 w-6 text-gray-400 dark:text-gray-500 shrink-0')
                <span>{{ $post->time }}</span>
            </div>
        </div>

        <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 font-medium mt-4">
            @icon('users', 'h-6 w-6 text-gray-400 dark:text-gray-500 shrink-0')
            <span>Captain Jean-Luc Picard, Commander William Riker, and Dr. Beverly Crusher</span>
        </div>

        <hr class="w-full max-w-xl mt-8 border-gray-200 dark:border-gray-200/10 mx-auto">

        <div class="prose dark:prose-invert max-w-none mt-8">
            {!! $post->content !!}
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-50 dark:bg-gray-700/50 rounded-b-lg" height="sm" width="sm">
        <x-button color="white" wire:click="dismiss">Close</x-button>
    </x-content-box>
</div>
