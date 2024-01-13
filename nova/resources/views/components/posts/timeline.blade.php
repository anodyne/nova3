@props([
    'posts',
    'story',
])

<x-panel>
    <x-spacing size="xs">
        @foreach ($posts as $post)
            <div
                class="relative grid grid-cols-12 items-baseline overflow-hidden p-3 sm:p-5"
                wire:key="post-{{ $post->id }}"
            >
                <div class="col-span-1 col-start-1 row-start-1 mb-1 flex items-center font-medium md:row-end-3 md:mb-0">
                    <svg viewBox="0 0 12 12" class="mr-6 h-3 w-3 overflow-visible">
                        <!-- Circle -->
                        <circle cx="6" cy="6" r="6" fill="{{ $post->postType->color }}"></circle>

                        {{--
                            @if ($post->is_current)
                            <!-- Ring -->
                            <circle cx="6" cy="6" r="11" fill="none" stroke="currentColor" stroke-width="2" class="text-{{ $post->status->color() }}-9"></circle>
                            @endif
                        --}}

                        @unless ($loop->last)
                            <!-- Lower arm -->
                            <path
                                d="M 6 18 V 100000"
                                fill="none"
                                stroke-width="2"
                                stroke="currentColor"
                                class="text-gray-300 dark:text-gray-600"
                            ></path>
                        @endunless

                        @unless ($loop->first)
                            <!-- Upper arm -->
                            <path
                                d="M 6 -6 V -30"
                                fill="none"
                                stroke-width="2"
                                stroke="currentColor"
                                class="text-gray-300 dark:text-gray-600"
                            ></path>
                        @endunless
                    </svg>
                </div>

                <div class="col-span-11 col-start-2 ml-0 text-gray-600">
                    @if (view()->exists("pages.posts.post-types.{$post->postType->key}"))
                        @include("pages.posts.post-types.{$post->postType->key}")
                    @else
                        @include('pages.posts.post-types.generic')
                    @endif
                </div>
            </div>
        @endforeach
    </x-spacing>
</x-panel>
