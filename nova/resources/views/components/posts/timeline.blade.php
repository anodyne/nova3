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
                        <circle cx="6" cy="6" r="6" fill="{{ $post->postType->color }}"></circle>

                        {{-- @if ($post->is_current)
                            <!-- Ring -->
                            <circle cx="6" cy="6" r="11" fill="none" stroke="currentColor" stroke-width="2" class="text-{{ $post->status->color() }}-9"></circle>
                        @endif --}}

                        @unless ($loop->last)
                            <!-- Lower arm -->
                            <path d="M 6 18 V 100000" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-300 dark:text-gray-600"></path>
                        @endunless

                        @unless ($loop->first)
                            <!-- Upper arm -->
                            <path d="M 6 -6 V -30" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-300 dark:text-gray-600"></path>
                        @endunless
                    </svg>
                </div>

                <div class="col-start-2 col-span-11 ml-0 text-gray-600">
                    @if (view()->exists("pages.posts.post-types.{$post->postType->key}"))
                        @include("pages.posts.post-types.{$post->postType->key}")
                    @else
                        @include('pages.posts.post-types.generic')
                    @endif
                </div>
            </div>
        @endforeach
    </x-content-box>
</x-panel>
