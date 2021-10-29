<div>
    <x-content-box>
        <x-page-header :pretitle="$post->story->title">
            {{ $post->title }}
        </x-page-header>

        <div class="flex items-center space-x-6">
            <div class="flex items-center space-x-2 text-sm text-gray-11 font-medium">
                @icon('location', 'h-6 w-6 text-gray-9 flex-shrink-0')
                <span>{{ $post->location }}</span>
            </div>

            <div class="flex items-center space-x-2 text-sm text-gray-11 font-medium">
                @icon('calendar', 'h-6 w-6 text-gray-9 flex-shrink-0')
                <span>{{ $post->day }}</span>
            </div>

            <div class="flex items-center space-x-2 text-sm text-gray-11 font-medium">
                @icon('clock', 'h-6 w-6 text-gray-9 flex-shrink-0')
                <span>{{ $post->time }}</span>
            </div>
        </div>

        <div class="flex items-center space-x-2 text-sm text-gray-11 font-medium mt-4">
            @icon('users', 'h-6 w-6 text-gray-9 flex-shrink-0')
            <span>Captain Jean-Luc Picard, Commander William Riker, and Dr. Beverly Crusher</span>
        </div>

        <hr class="w-full max-w-xl mt-12 border-gray-6 mx-auto">

        <div class="prose max-w-none mt-12">
            {!! $post->content !!}
        </div>
    </x-content-box>
</div>
