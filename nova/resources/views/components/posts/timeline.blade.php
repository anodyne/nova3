@props([
    'posts',
    'story',
])

<x-panel>
    <x-content-box height="xs" width="xs">
        @foreach ($posts as $post)
            <div class="grid grid-cols-12 items-baseline relative p-3 sm:p-5 overflow-hidden" wire:key="post-{{ $post->id }}">
                <div class="col-start-1 col-span-1 row-start-1 md:row-end-3 flex items-center font-medium mb-1 md:mb-0">
                    <svg viewBox="0 0 12 12" class="w-3 h-3 mr-6 overflow-visible">
                        <!-- Circle -->
                        <circle cx="6" cy="6" r="6" fill="{{ $post->type->color }}"></circle>

                        {{-- @if ($post->is_current)
                            <!-- Ring -->
                            <circle cx="6" cy="6" r="11" fill="none" stroke="currentColor" stroke-width="2" class="text-{{ $post->status->color() }}-9"></circle>
                        @endif --}}

                        @if (request('sort', 'desc') === 'desc' && $post->getNextSibling())
                            <!-- Lower arm -->
                            <path d="M 6 18 V 100000" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-6"></path>
                        @endif

                        @if (request('sort', 'desc') === 'asc' && $post->getPrevSibling())
                            <!-- Lower arm -->
                            <path d="M 6 18 V 100000" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-6"></path>
                        @endif

                        @if (request('sort', 'desc') === 'desc' && $post->getPrevSibling())
                            <!-- Upper arm -->
                            <path d="M 6 -6 V -10000" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-6"></path>
                        @endif

                        @if (request('sort', 'desc') === 'asc' && $post->getNextSibling())
                            <!-- Upper arm -->
                            <path d="M 6 -6 V -10000" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-6"></path>
                        @endif
                    </svg>
                </div>

                <div class="col-start-2 col-span-11 ml-0 text-gray-11">
                    @if (view()->exists("pages.posts.post-types.{$post->type->key}"))
                        @include("pages.posts.post-types.{$post->type->key}")
                    @else
                        @include('pages.posts.post-types.generic')
                    @endif
                </div>
            </div>
        @endforeach
    </x-content-box>
</x-panel>