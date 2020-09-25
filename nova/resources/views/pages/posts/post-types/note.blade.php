<div class="block bg-gray-100">
    <div class="flex items-center relative px-4 py-4 | sm:px-6">
        <div class="absolute top-0 right-0 pt-4 pr-4 | sm:pr-6">
            @icon('more', 'h-6 w-6 text-gray-400')
        </div>

        <div class="flex flex-col items-center flex-1">
            <div class="flex flex-col flex-1 w-full space-y-2">
                <div class="flex items-center space-x-2 justify-center">
                    <span style="color:{{ $post->type->color }}">
                        @icon($post->type->icon, 'h-6 w-6')
                    </span>
                    <div class="font-bold text-xl tracking-tight truncate">{{ $post->title ?? 'Story Note' }}</div>
                </div>

                @if ($post->day || $post->time || $post->location)
                    <div class="flex justify-center space-x-4">
                        @if ($post->day)
                            <div class="flex items-center text-sm text-gray-700 space-x-1.5">
                                @icon('calendar', 'flex-shrink-0 h-5 w-5 text-gray-500')
                                <span>{{ $post->day }}</span>
                            </div>
                        @endif

                        @if ($post->time)
                            <div class="flex items-center text-sm text-gray-700 space-x-1.5">
                                @icon('clock', 'flex-shrink-0 h-5 w-5 text-gray-500')
                                <span>{{ $post->time }}</span>
                            </div>
                        @endif

                        @if ($post->location)
                            <div class="flex items-center text-sm text-gray-700 space-x-1.5">
                                @icon('location', 'flex-shrink-0 h-5 w-5 text-gray-500')
                                <span>{{ $post->location }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="prose prose-sm max-w-full">{!! $post->content !!}</div>
            </div>
        </div>
    </div>
</div>