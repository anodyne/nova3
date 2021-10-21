<div class="block bg-gray-1 rounded-md shadow">
    <div class="flex items-start space-x-4 px-4 py-4 sm:px-6">
        <div class="flex-shrink-0 rounded-full p-1.5 border-2" style="left:6px; border-color:{{ $post->type->color }};color:{{ $post->type->color }}">
            @icon($post->type->icon, 'h-6 w-6')
        </div>

        <div class="flex-1 space-y-2">
            <div>
                <h3 class="uppercase tracking-wide text-xs text-gray-500 font-semibold">{{ $post->type->name }}</h3>
                <h2 class="font-bold text-2xl truncate tracking-tight">{{ $post->title }}</h2>
            </div>

            <div class="block">
                <div class="flex items-center overflow-hidden space-x-2">
                    <img class="inline-block h-8 w-8 rounded-full text-white shadow-solid" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <span class="text-gray-700 font-medium">Tom Cook</span>
                </div>
            </div>

            @if ($post->day || $post->time || $post->location)
                <div class="flex space-x-6">
                    @if ($post->day)
                        <div class="hidden items-center text-sm text-gray-600 sm:flex">
                            @icon('calendar', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                            <span>{{ $post->day }}</span>
                        </div>
                    @endif

                    @if ($post->time)
                        <div class="hidden items-center text-sm text-gray-600 sm:flex">
                            @icon('clock', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                            <span>{{ $post->time }}</span>
                        </div>
                    @endif

                    @if ($post->location)
                        <div class="hidden items-center text-sm text-gray-600 sm:flex">
                            @icon('location', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                            <span>{{ $post->location }}</span>
                        </div>
                    @endif
                </div>
            @endif

            <div class="flex space-x-6">
                <x-badge :color="$post->status->color()" size="xs">{{ $post->status->displayName() }}</x-badge>
                @if ($post->published_at)
                    <div class="hidden items-center text-sm text-gray-500 sm:flex">
                        Published&nbsp;
                        <time datetime="{{ $post->published_at }}">
                            {{ $post->published_at->format('M d, Y') }}
                        </time>
                    </div>
                @endif
            </div>
        </div>

        <x-icon.more class="h-6 w-6 text-gray-9 flex-shrink-0" />
    </div>
</div>