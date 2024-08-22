@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header
            title="Posting activity settings"
            message="Set your game’s posting activity requirements and how you want posts and words counted"
        >
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" plain>
                        <x-icon name="search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>
        </x-panel.header>

        <x-form
            :action="route('admin.settings.posting-activity.update')"
            method="PUT"
            x-data="{
                strategy: '{{ $settings->trackingStrategy }}',
                postsStrategy: '{{ $settings->postsStrategy }}',
                wordCountStrategy: '{{ $settings->wordCountStrategy }}'
            }"
            x-cloak
        >
            <x-form.section
                title="Activity tracking strategy"
                message="Nova provides for two options to track posting activity: by entire posts or by word counts. You can specify whether a specific post type is included in the posting activity from each post type’s settings."
            >
                <fieldset x-data="{ strategy: 'posts' }">
                    <legend class="sr-only">Activity tracking strategy</legend>

                    <div class="space-y-4">
                        <label
                            for="strategy_posts"
                            class="flex flex-col rounded-lg px-6 py-4"
                            x-bind:class="{
                                'shadow-md ring-1 ring-inset ring-gray-950/10 dark:bg-gray-800 dark:shadow-lg dark:ring-white/5':
                                    strategy === 'posts',
                                'transition hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer':
                                    strategy !== 'posts',
                            }"
                        >
                            <input
                                type="radio"
                                name="strategy"
                                id="strategy_posts"
                                value="posts"
                                class="hidden"
                                x-model="strategy"
                            />

                            <div class="flex w-full appearance-none justify-between">
                                <div class="flex flex-col gap-1">
                                    <h3 class="text-left text-base font-semibold text-gray-900 dark:text-white">
                                        Story posts
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Activity level is based on the number of published posts
                                    </p>
                                </div>
                                <div class="ml-8 flex shrink-0 space-x-3">
                                    <x-icon
                                        name="add"
                                        size="md"
                                        class="text-gray-400 dark:text-gray-500"
                                        x-show="strategy !== 'posts'"
                                    ></x-icon>
                                    <x-icon
                                        name="remove"
                                        size="md"
                                        class="text-gray-400 dark:text-gray-500"
                                        x-show="strategy === 'posts'"
                                    ></x-icon>
                                </div>
                            </div>

                            <div x-show="strategy === 'posts'" x-collapse x-cloak>
                                <div
                                    class="mt-6 flex justify-between border-t border-gray-900/10 pt-6 dark:border-white/5"
                                >
                                    <div class="space-y-3">
                                        <x-fieldset.field
                                            label="Required number of published story posts"
                                            id="bar"
                                            name="bar"
                                        >
                                            <x-input.text trailing="per month"></x-input.text>
                                        </x-fieldset.field>
                                    </div>
                                </div>

                                <div
                                    class="mt-6 flex justify-between border-t border-gray-900/10 pt-6 dark:border-white/5"
                                >
                                    <div class="space-y-1">
                                        <h3 class="text-base font-medium text-gray-700 dark:text-gray-200">
                                            Count a post for each author
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            A story post with 5 authors will count as 5 posts in total (1 for each
                                            unique author)
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            A story post with 5 authors will attribute 1 post in total
                                        </p>
                                    </div>
                                    <div
                                        class="ml-8 shrink-0 pt-0.5"
                                        x-on:toggle-switch-changed="enabled = !enabled"
                                    >
                                        <x-switch></x-switch>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <label
                            for="strategy_words"
                            class="flex flex-col rounded-lg px-6 py-4"
                            x-bind:class="{
                                'shadow-md ring-1 ring-inset ring-gray-950/10 dark:bg-gray-800 dark:shadow-lg dark:ring-white/5':
                                    strategy === 'words',
                                'transition hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer':
                                    strategy !== 'words',
                            }"
                        >
                            <input
                                type="radio"
                                name="strategy"
                                id="strategy_words"
                                value="words"
                                class="hidden"
                                x-model="strategy"
                            />

                            <div class="flex w-full appearance-none justify-between">
                                <div class="flex flex-col gap-1">
                                    <h3 class="text-left text-base font-semibold text-gray-900 dark:text-white">
                                        Story post words
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Activity level is based on the number of words in published posts
                                    </p>
                                </div>
                                <div class="ml-8 flex shrink-0 space-x-3">
                                    <x-icon
                                        name="chevron-down"
                                        size="md"
                                        class="text-gray-400 dark:text-gray-500"
                                        x-show="strategy !== 'words'"
                                    ></x-icon>
                                    <x-icon
                                        name="chevron-up"
                                        size="md"
                                        class="text-gray-400 dark:text-gray-500"
                                        x-show="strategy === 'words'"
                                    ></x-icon>
                                </div>
                            </div>

                            <div x-show="strategy === 'words'" x-collapse x-cloak>
                                <div
                                    class="mt-6 flex justify-between border-t border-gray-900/10 pt-6 dark:border-white/5"
                                >
                                    <div class="space-y-3">
                                        <x-fieldset.field
                                            label="Required number of published story post words"
                                            id="baz"
                                            name="baz"
                                        >
                                            <x-input.text trailing="per month"></x-input.text>
                                        </x-fieldset.field>
                                    </div>
                                </div>

                                <div
                                    class="mt-6 flex justify-between border-t border-gray-900/10 pt-6 dark:border-white/5"
                                >
                                    <div class="space-y-1">
                                        <h3 class="text-base font-medium text-gray-700 dark:text-gray-200">
                                            Count all words for each author
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            A story post with 500 words and 2 authors would attribute 500 words to
                                            Author a and 500 words to Author B
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            A story post with 500 words and 2 authors would attribute 250 words to
                                            Author a and 250 words to Author B
                                        </p>
                                    </div>
                                    <div
                                        class="ml-8 shrink-0 pt-0.5"
                                        x-on:toggle-switch-changed="enabled = !enabled"
                                    >
                                        <x-switch></x-switch>
                                    </div>
                                </div>

                                <div
                                    class="mt-6 flex justify-between border-t border-gray-900/10 pt-6 dark:border-white/5"
                                >
                                    <div class="space-y-3">
                                        <x-fieldset.field label="Story post word count conversion" id="foo" name="foo">
                                            <x-input.text leading="1 story post equals" trailing="words"></x-input.text>
                                        </x-fieldset.field>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </fieldset>
            </x-form.section>

            <x-form.section
                title="Activity level tracking strategy"
                message="Nova provides for two options to track posting activity: by entire posts or by word counts. You can specify whether a specific post type is included in the posting activity from each post type’s settings."
            >
                <fieldset>
                    <legend class="sr-only">Activity Level Tracking Strategy</legend>
                    <div class="space-y-4">
                        <label
                            class="relative block cursor-pointer rounded-md border border-gray-300 bg-white px-6 py-4 shadow-sm transition hover:border-gray-400 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:shadow-none sm:flex sm:justify-between"
                        >
                            <input
                                type="radio"
                                name="tracking-strategy"
                                value="posts"
                                class="sr-only"
                                aria-labelledby="tracking-strategy-0-label"
                                aria-describedby="tracking-strategy-0-description-0 tracking-strategy-0-description-1"
                                x-model="strategy"
                            />
                            <div class="flex items-center">
                                <div class="text-sm">
                                    <p
                                        id="tracking-strategy-0-label"
                                        class="font-medium text-gray-900 dark:text-gray-100"
                                    >
                                        Story Posts
                                    </p>
                                    <div
                                        id="tracking-strategy-0-description-0"
                                        class="mt-0.5 text-gray-600 dark:text-gray-400"
                                    >
                                        <p class="sm:inline">Activity levels based on the number of posts</p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="pointer-events-none absolute -inset-px rounded-md border-2"
                                aria-hidden="true"
                                :class="{ 'border-primary-500': strategy === 'posts', 'border-transparent': strategy !== 'posts' }"
                            ></div>
                        </label>

                        <label
                            class="relative block cursor-pointer rounded-md border border-gray-300 bg-white px-6 py-4 shadow-sm transition hover:border-gray-400 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:shadow-none sm:flex sm:justify-between"
                        >
                            <input
                                type="radio"
                                name="tracking-strategy"
                                value="words"
                                class="sr-only"
                                aria-labelledby="tracking-strategy-1-label"
                                aria-describedby="tracking-strategy-1-description-0 tracking-strategy-1-description-1"
                                x-model="strategy"
                            />
                            <div class="flex items-center">
                                <div class="text-sm">
                                    <p
                                        id="tracking-strategy-1-label"
                                        class="font-medium text-gray-900 dark:text-gray-100"
                                    >
                                        Story Post Words
                                    </p>
                                    <div
                                        id="tracking-strategy-1-description-1"
                                        class="mt-0.5 text-gray-600 dark:text-gray-400"
                                    >
                                        <p class="sm:inline">Activity levels based on the number of words in posts</p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="pointer-events-none absolute -inset-px rounded-md border-2"
                                aria-hidden="true"
                                :class="{ 'border-primary-500': strategy === 'words', 'border-transparent': strategy !== 'words' }"
                            ></div>
                        </label>
                    </div>
                </fieldset>
            </x-form.section>

            <x-form.section
                title="Monthly required activity level"
                message="Set the specific requirements your game has around posting activity for users."
            >
                <x-fieldset.field id="required_activity" name="required-activity">
                    <x-slot name="label">
                        <span x-show="strategy === 'posts'">Story posts</span>
                        <span x-show="strategy === 'words'">Story post words</span>
                        <span>per month</span>
                    </x-slot>

                    <x-input.text value="{{ $settings->requiredActivity }}" />
                </x-fieldset.field>
            </x-form.section>

            <x-form.section
                title="Per story post tracking"
                message="Track user activity based purely on the number of posts that are published. This is traditionally how Nova has calculated posts and tracked user posting activity in the past."
                x-show="strategy === 'posts'"
            >
                <fieldset>
                    <legend class="sr-only">Per Story Post Tracking</legend>
                    <div class="-space-y-px rounded-md bg-white dark:bg-gray-800">
                        <label
                            class="relative flex cursor-pointer rounded-tl-md rounded-tr-md border p-4 focus:outline-none"
                            :class="{ 'bg-primary-50 dark:bg-primary-900 border-primary-300 dark:border-primary-600 z-10': postsStrategy === 'author', 'border-gray-300 dark:border-gray-600': postsStrategy !== 'author' }"
                        >
                            <input
                                type="radio"
                                name="posts-strategy"
                                value="author"
                                class="mt-0.5 size-4 cursor-pointer border-gray-300 bg-white focus:ring-primary-500 focus:ring-offset-primary-50 dark:focus:ring-offset-primary-900"
                                :class="{ 'text-primary-600': postsStrategy === 'author' }"
                                aria-labelledby="posts-strategy-0-label"
                                aria-describedby="posts-strategy-0-description"
                                x-model="postsStrategy"
                            />
                            <div class="ml-3 flex flex-col">
                                <span
                                    id="posts-strategy-0-label"
                                    class="block text-sm font-medium"
                                    :class="{ 'text-primary-900 dark:text-primary-100': postsStrategy === 'author', 'text-gray-900 dark:text-gray-100': postsStrategy !== 'author' }"
                                >
                                    Attribute a post to each author
                                </span>
                                <span
                                    id="posts-strategy-0-description"
                                    class="block text-sm text-primary-600 dark:text-primary-400"
                                    :class="{ 'text-primary-600 dark:text-primary-400': postsStrategy === 'author', 'text-gray-600 dark:text-gray-400': postsStrategy !== 'author' }"
                                >
                                    A story post with 5 authors would attribute each author with 1 post (a total of 5
                                    posts)
                                </span>
                            </div>
                        </label>

                        <label
                            class="relative flex cursor-pointer rounded-bl-md rounded-br-md border p-4 focus:outline-none"
                            :class="{ 'bg-primary-50 dark:bg-primary-900 border-primary-300 dark:border-primary-600 z-10': postsStrategy === 'post', 'border-gray-300 dark:border-gray-600': postsStrategy !== 'post' }"
                        >
                            <input
                                type="radio"
                                name="posts-strategy"
                                value="post"
                                class="mt-0.5 size-4 shrink-0 cursor-pointer border-gray-300 bg-white focus:ring-primary-500 focus:ring-offset-primary-50 dark:focus:ring-offset-primary-900"
                                :class="{ 'text-primary-600 dark:text-primary-400': postsStrategy === 'author' }"
                                aria-labelledby="posts-strategy-1-label"
                                aria-describedby="posts-strategy-1-description"
                                x-model="postsStrategy"
                            />
                            <div class="ml-3 flex flex-col">
                                <span
                                    id="posts-strategy-1-label"
                                    class="block text-sm font-medium"
                                    :class="{ 'text-primary-900 dark:text-primary-100': postsStrategy === 'post', 'text-gray-900 dark:text-gray-100': postsStrategy !== 'post' }"
                                >
                                    Attribute a single post
                                </span>
                                <span
                                    id="posts-strategy-1-description"
                                    class="block text-sm"
                                    :class="{ 'text-primary-600 dark:text-primary-400': postsStrategy === 'post', 'text-gray-600 dark:text-gray-400': postsStrategy !== 'post' }"
                                >
                                    A story post with 5 authors would attribute 1 post in total
                                </span>
                            </div>
                        </label>
                    </div>
                </fieldset>
            </x-form.section>

            <x-form.section
                title="Story post word count tracking"
                message="Track user activity based on the number of words in published posts."
                x-show="strategy === 'words'"
            >
                <fieldset>
                    <legend class="sr-only">Story Post Word Count Tracking</legend>
                    <div class="-space-y-px rounded-md bg-white dark:bg-gray-800">
                        <!-- Checked: "bg-indigo-50 border-indigo-200 z-10", Not Checked: "border-gray-200" -->
                        <label
                            class="relative flex cursor-pointer rounded-tl-md rounded-tr-md border p-4 focus:outline-none"
                            :class="{ 'bg-primary-50 dark:bg-primary-900 border-primary-300 dark:border-primary-600 z-10': wordCountStrategy === 'all', 'border-gray-300 dark:border-gray-600': wordCountStrategy !== 'all' }"
                        >
                            <input
                                type="radio"
                                name="word-count-strategy"
                                value="all"
                                class="mt-0.5 size-4 shrink-0 cursor-pointer border-gray-300 bg-white focus:ring-primary-500 focus:ring-offset-primary-50 dark:focus:ring-offset-primary-900"
                                :class="{ 'text-primary-600 dark:text-primary-400': wordCountStrategy === 'all' }"
                                aria-labelledby="word-count-strategy-0-label"
                                aria-describedby="word-count-strategy-0-description"
                                x-model="wordCountStrategy"
                            />
                            <div class="ml-3 flex flex-col">
                                <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
                                <span
                                    id="word-count-strategy-0-label"
                                    class="block text-sm font-medium"
                                    :class="{ 'text-primary-900 dark:text-primary-100': wordCountStrategy === 'all', 'text-gray-900 dark:text-gray-100': wordCountStrategy !== 'all' }"
                                >
                                    Attribute all words to each author
                                </span>
                                <!-- Checked: "text-indigo-700", Not Checked: "text-gray-500" -->
                                <span
                                    id="word-count-strategy-0-description"
                                    class="block text-sm"
                                    :class="{ 'text-primary-600 dark:text-primary-400': wordCountStrategy === 'all', 'text-gray-600 dark:text-gray-400': wordCountStrategy !== 'all' }"
                                >
                                    A story post with 500 words and 2 authors would attribute 500 words to Author A and
                                    500 words to Author B
                                </span>
                            </div>
                        </label>

                        <!-- Checked: "bg-indigo-50 border-indigo-200 z-10", Not Checked: "border-gray-200" -->
                        <label
                            class="relative flex cursor-pointer rounded-bl-md rounded-br-md border p-4 focus:outline-none"
                            :class="{ 'bg-primary-50 dark:bg-primary-900 border-primary-300 dark:border-primary-600 z-10': wordCountStrategy === 'average', 'border-gray-300 dark:border-gray-600': wordCountStrategy !== 'average' }"
                        >
                            <input
                                type="radio"
                                name="word-count-strategy"
                                value="average"
                                class="mt-0.5 size-4 shrink-0 cursor-pointer border-gray-300 bg-white focus:ring-primary-500 focus:ring-offset-primary-50 dark:focus:ring-offset-primary-900"
                                :class="{ 'text-primary-600 dark:text-primary-400': wordCountStrategy === 'average' }"
                                aria-labelledby="word-count-strategy-1-label"
                                aria-describedby="word-count-strategy-1-description"
                                x-model="wordCountStrategy"
                            />
                            <div class="ml-3 flex flex-col">
                                <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
                                <span
                                    id="word-count-strategy-1-label"
                                    class="block text-sm font-medium"
                                    :class="{ 'text-primary-900 dark:text-primary-100': wordCountStrategy === 'average', 'text-gray-900 dark:text-gray-100': wordCountStrategy !== 'average' }"
                                >
                                    Attribute an average of words per author to each author
                                </span>
                                <!-- Checked: "text-indigo-700", Not Checked: "text-gray-500" -->
                                <span
                                    id="word-count-strategy-1-description"
                                    class="block text-sm"
                                    :class="{ 'text-primary-600 dark:text-primary-400': wordCountStrategy === 'average', 'text-gray-600 dark:text-gray-400': wordCountStrategy !== 'average' }"
                                >
                                    A story post with 500 words and 2 authors would attribute 250 words to Author A and
                                    250 words to Author B
                                </span>
                            </div>
                        </label>
                    </div>
                </fieldset>

                <x-fieldset.field
                    label="Story post word count conversion"
                    id="word_count_post_conversion"
                    name="word-count-post-conversion"
                >
                    <x-input.text
                        value="{{ $settings->wordCountPostConversion }}"
                        leading="1 story post equals"
                        trailing="words"
                    />
                </x-fieldset.field>
            </x-form.section>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-panel>
@endsection
