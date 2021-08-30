<div class="block bg-gray-1 rounded-md shadow">
    <div class="flex items-start space-x-4 px-4 py-4 | sm:px-6">
        <div class="flex-shrink-0 rounded-full p-1.5 border-2" style="left:6px; border-color:{{ $post->type->color }};color:{{ $post->type->color }}">
            @icon($post->type->icon, 'h-6 w-6')
        </div>

        <div class="flex-1 space-y-2">
            <div>
                <h3 class="uppercase tracking-wide text-xs text-gray-500 font-semibold">{{ $post->type->name }}</h3>
                <h2 class="font-bold text-2xl truncate tracking-tight">{{ $post->title }}</h2>
            </div>

            @if ($post->day || $post->time || $post->location)
                <div class="flex flex-col space-x-6 | md:flex-row">
                    @if ($post->day)
                        <div class="flex items-center text-sm text-gray-600 space-x-1.5">
                            @icon('calendar', 'flex-shrink-0 h-5 w-5 text-gray-400')
                            <span>{{ $post->day }}</span>
                        </div>
                    @endif

                    @if ($post->time)
                        <div class="flex items-center text-sm text-gray-600 space-x-1.5">
                            @icon('clock', 'flex-shrink-0 h-5 w-5 text-gray-400')
                            <span>{{ $post->time }}</span>
                        </div>
                    @endif

                    @if ($post->location)
                        <div class="flex items-center text-sm text-gray-600 space-x-1.5">
                            @icon('location', 'flex-shrink-0 h-5 w-5 text-gray-400')
                            <span>{{ $post->location }}</span>
                        </div>
                    @endif
                </div>
            @endif

            <div class="block">
                <div class="flex overflow-hidden">
                    <img class="inline-block h-8 w-8 rounded-full text-white shadow-solid" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <img class="-ml-1 inline-block h-8 w-8 rounded-full text-white shadow-solid" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <img class="-ml-1 inline-block h-8 w-8 rounded-full text-white shadow-solid" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="">
                    <img class="-ml-1 inline-block h-8 w-8 rounded-full text-white shadow-solid" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                </div>
            </div>

            <div class="flex space-x-6">
                <x-badge :color="$post->status->color()" size="xs">{{ $post->status->displayName() }}</x-badge>
                @if ($post->published_at)
                    <div class="hidden items-center text-sm text-gray-500 | sm:flex">
                        Published&nbsp;
                        <time datetime="{{ $post->published_at }}">
                            {{ $post->published_at->format('M d, Y') }}
                        </time>
                    </div>
                @endif
            </div>
        </div>

        @icon('more', 'h-6 w-6 text-gray-400 flex-shrink-0')
    </div>
</div>