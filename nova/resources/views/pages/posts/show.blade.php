@extends($meta->template)

@section('content')
    <x-page-header>
        <x-slot:pretitle>
            <a href="{{ route('stories.show', $story) }}">
                {{ $story->title }}
            </a>
        </x-slot:pretitle>

        {{ $post->title }}

        <x-slot:controls>
            @if ($previousPost)
                <x-link :href="route('posts.show', [$story, $previousPost])" size="none" color="gray-text">
                    <x-icon.chevron-left class="h-7 w-7 md:h-6 md:w-6" />
                </x-link>
            @endif

            @if ($nextPost)
                <x-link :href="route('posts.show', [$story, $nextPost])" size="none" color="gray-text">
                    <x-icon.chevron-right class="h-7 w-7 md:h-6 md:w-6" />
                </x-link>
            @endif

            @can('update', $post)
                <x-link href="#" color="primary">
                    Edit post
                </x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    <x-panel x-data="{ showContent: {{ $post->shouldShowContentWarning() ? 'false' : 'true' }} }">
        <x-content-box class="text-center p-16" x-show="!showContent" x-cloak>
            <div class="flex items-center justify-center space-x-4">
                @icon('warning', 'h-8 w-8 text-danger-500')
                <h1 class="block text-4xl leading-loose font-extrabold text-danger-600 tracking-tight">Warning</h1>
                @icon('warning', 'h-8 w-8 text-danger-500')
            </div>

            <p class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                This post contains mature content that may not be suitable for all audiences.
            </p>

            <ul class="font-medium text-gray-600 dark:text-gray-400 mb-4">
                @if ($post->rating_language >= settings()->ratings->language->warning_threshold)
                    <li>{{ settings()->ratings->language->warning_threshold_message }}</li>
                @endif

                @if ($post->rating_sex >= settings()->ratings->sex->warning_threshold)
                    <li>{{ settings()->ratings->sex->warning_threshold_message }}</li>
                @endif

                @if ($post->rating_violence >= settings()->ratings->violence->warning_threshold)
                    <li>{{ settings()->ratings->violence->warning_threshold_message }}</li>
                @endif
            </ul>

            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-8">
                By continuing, you agree that you are of suitable age for this content.
            </p>

            <x-button type="button" color="error-outline" @click="showContent = true">
                Continue
            </x-button>
        </x-content-box>

        <x-content-box x-show="showContent" x-cloak>
            <div class="grid md:grid-cols-4 md:gap-16">
                <div class="order-1 mb-8 md:mb-0 md:order-2 md:col-span-1">
                    <div class="space-y-10">
                        <div class="flex items-start space-x-2 text-gray-500 dark:text-gray-400 font-medium">
                            <span style="color:{{ $post->postType->color }}">
                                @icon($post->postType->icon, 'h-6 w-6 shrink-0')
                            </span>
                            <span>{{ $post->postType->name }}</span>
                        </div>

                        @if ($post->postType->fields->location->enabled || $post->postType->fields->day->enabled || $post->postType->fields->time->enabled)
                            <div class="flex flex-col space-y-3">
                                @if ($post->postType->fields->location->enabled && $post->location)
                                    <div class="flex items-start space-x-2 text-gray-500 dark:text-gray-400 font-medium">
                                        @icon('location', 'h-6 w-6 text-gray-400 dark:text-gray-500 shrink-0')
                                        <span>{{ $post->location }}</span>
                                    </div>
                                @endif

                                @if ($post->postType->fields->day->enabled && $post->day)
                                    <div class="flex items-start space-x-2 text-gray-500 dark:text-gray-400 font-medium">
                                        @icon('calendar', 'h-6 w-6 text-gray-400 dark:text-gray-500 shrink-0')
                                        <span>{{ $post->day }}</span>
                                    </div>
                                @endif

                                @if ($post->postType->fields->time->enabled && $post->time)
                                    <div class="flex items-start space-x-2 text-gray-500 dark:text-gray-400 font-medium">
                                        @icon('clock', 'h-6 w-6 text-gray-400 dark:text-gray-500 shrink-0')
                                        <span>{{ $post->time }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="flex flex-col space-y-3">
                            <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 font-medium">
                                @icon('number', 'h-6 w-6 text-gray-400 dark:text-gray-500 shrink-0')
                                <span>{{ number_format($post->word_count) }} words</span>
                            </div>

                            <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 font-medium">
                                @icon('timer', 'h-6 w-6 text-gray-400 dark:text-gray-500 shrink-0')
                                <span>{{ ceil($post->word_count / 200) }} min read</span>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-3 text-gray-500 dark:text-gray-400 font-medium">
                            <div class="text-xs uppercase font-semibold tracking-wide text-gray-400 dark:text-gray-500">
                                Content Rating
                            </div>
                            <span>{{ $post->rating_language }} {{ $post->rating_sex }} {{ $post->rating_violence }}</span>
                        </div>

                        <div class="flex flex-col space-y-3 text-gray-500 dark:text-gray-400 font-medium">
                            <div class="text-xs uppercase font-semibold tracking-wide text-gray-400 dark:text-gray-500">Authors</div>

                            <div class="flex items-center space-x-2">
                                <img class="inline-block h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                <span>Tom Cook</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <img class="inline-block h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                <span>Melon Dusk</span>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-3 text-gray-600 font-medium">
                            <div>
                                <x-badge :color="$post->status->color()">
                                    {{ $post->status->displayName() }}
                                </x-badge>
                            </div>

                            <div class="flex flex-col space-y-1 text-base md:text-sm text-gray-500 dark:text-gray-400 font-medium ml-1">
                                {{-- <span class="text-gray-500 uppercase tracking-wide text-sm md:text-xs">Published</span> --}}
                                <time datetime="{{ $post->published_at }}">
                                    {{ $post->published_at->format('M dS, Y @ g:ma') }}
                                </time>
                            </div>

                            @if (! $post->updated_at->eq($post->published_at))
                                <div class="flex flex-col space-y-1 text-base md:text-sm text-gray-600 font-medium ml-1">
                                    <span class="text-gray-500 uppercase tracking-wide text-sm md:text-xs">Last Updated</span>
                                    <time datetime="{{ $post->updated_at }}">
                                        {{ $post->updated_at->format('M dS, Y @ g:ma') }}
                                    </time>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="order-2 md:order-1 md:col-span-3 space-y-8">
                    <div class="prose dark:prose-invert prose-lg max-w-none">
                        {!! $post->content !!}
                    </div>

                    <x-panel as="light well">
                        <x-content-box>
                            <div class="grid md:grid-cols-2 md:gap-6">
                                @foreach($post->characterAuthors as $character)
                                    <x-avatar.character :character="$character"></x-avatar.character>
                                @endforeach

                                @foreach($post->userAuthors as $user)
                                    <x-avatar.meta :src="$user->avatar_url" :primary="$user->name">
                                        @if ($user->pivot->as)
                                            <x-slot:secondary>
                                                as {{ $user->pivot->as }}
                                            </x-slot:secondary>
                                        @endif
                                    </x-avatar.meta>
                                @endforeach
                            </div>
                        </x-content-box>
                    </x-panel>
                </div>
            </div>
        </x-content-box>
    </x-panel>
@endsection
