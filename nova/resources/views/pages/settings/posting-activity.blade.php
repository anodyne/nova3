@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Posting activity settings" message="Set your game's posting activity requirements and how you want posts and words counted.">
            <x-slot:actions>
                <div x-data="{}">
                    <x-button-outline leading="search" @click="$dispatch('toggle-spotlight')">
                        Find a setting
                    </x-button-outline>
                </div>
            </x-slot:actions>
        </x-panel.header>

        <x-form
            :action="route('settings.update', $tab)"
            method="PUT"
            id="posting"
            x-data="{ strategy: '{{ $settings->posting_activity->trackingStrategy }}', postsStrategy: '{{ $settings->posting_activity->postsStrategy }}', wordCountStrategy: '{{ $settings->posting_activity->wordCountStrategy }}' }"
            x-cloak
        >
            <x-form.section title="Activity level tracking strategy" message="Nova provides for two options to track posting activity: by entire posts or by word counts. You can specify whether a specific post type is included in the posting activity from each post type's settings.">
                <fieldset>
                    <legend class="sr-only">
                        Activity Level Tracking Strategy
                    </legend>
                    <div class="space-y-4">
                        <label class="relative block rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 shadow-sm dark:shadow-none px-6 py-4 cursor-pointer hover:border-gray-400 sm:flex sm:justify-between focus:outline-none transition">
                            <input type="radio" name="tracking-strategy" value="posts" class="sr-only" aria-labelledby="tracking-strategy-0-label" aria-describedby="tracking-strategy-0-description-0 tracking-strategy-0-description-1" x-model="strategy">
                            <div class="flex items-center">
                                <div class="text-sm">
                                    <p id="tracking-strategy-0-label" class="font-medium text-gray-900 dark:text-gray-100">
                                        Story Posts
                                    </p>
                                    <div id="tracking-strategy-0-description-0" class="text-gray-600 dark:text-gray-400 mt-0.5">
                                        <p class="sm:inline">Activity levels based on the number of posts</p>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute -inset-px rounded-md border-2 pointer-events-none" aria-hidden="true" :class="{ 'border-primary-500': strategy === 'posts', 'border-transparent': strategy !== 'posts' }"></div>
                        </label>

                        <label class="relative block rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 shadow-sm dark:shadow-none px-6 py-4 cursor-pointer hover:border-gray-400 sm:flex sm:justify-between focus:outline-none transition">
                            <input type="radio" name="tracking-strategy" value="words" class="sr-only" aria-labelledby="tracking-strategy-1-label" aria-describedby="tracking-strategy-1-description-0 tracking-strategy-1-description-1" x-model="strategy">
                            <div class="flex items-center">
                                <div class="text-sm">
                                    <p id="tracking-strategy-1-label" class="font-medium text-gray-900 dark:text-gray-100">
                                        Story Post Words
                                    </p>
                                    <div id="tracking-strategy-1-description-1" class="text-gray-600 dark:text-gray-400 mt-0.5">
                                        <p class="sm:inline">Activity levels based on the number of words in posts</p>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute -inset-px rounded-md border-2 pointer-events-none" aria-hidden="true" :class="{ 'border-primary-500': strategy === 'words', 'border-transparent': strategy !== 'words' }"></div>
                        </label>
                    </div>
                </fieldset>
            </x-form.section>

            <x-form.section title="Monthly required activity level" message="Set the specific requirements your game has around posting activity for users.">
                <x-input.group>
                    <x-slot:label>
                        <span x-show="strategy === 'posts'">Story posts</span>
                        <span x-show="strategy === 'words'">Story post words</span>
                        <span>per month</span>
                    </x-slot:label>

                    <x-input.text name="required-activity" value="{{ $settings->posting_activity->requiredActivity }}" />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Per story post tracking" message="Track user activity based purely on the number of posts that are published. This is traditionally how Nova has calculated posts and tracked user posting activity in the past." x-show="strategy === 'posts'">
                <fieldset>
                    <legend class="sr-only">
                        Per Story Post Tracking
                    </legend>
                    <div class="bg-white dark:bg-gray-800 rounded-md -space-y-px">
                        <label class="rounded-tl-md rounded-tr-md relative border p-4 flex cursor-pointer focus:outline-none" :class="{ 'bg-primary-50 dark:bg-primary-900 border-primary-300 dark:border-primary-600 z-10': postsStrategy === 'author', 'border-gray-300 dark:border-gray-600': postsStrategy !== 'author' }">
                            <input type="radio" name="posts-strategy" value="author" class="h-4 w-4 mt-0.5 cursor-pointer  border-gray-300 focus:ring-primary-500 bg-white focus:ring-offset-primary-50 dark:focus:ring-offset-primary-900" :class="{ 'text-primary-600': postsStrategy === 'author' }" aria-labelledby="posts-strategy-0-label" aria-describedby="posts-strategy-0-description" x-model="postsStrategy">
                            <div class="ml-3 flex flex-col">
                                <span id="posts-strategy-0-label" class="block text-sm font-medium" :class="{ 'text-primary-900 dark:text-primary-100': postsStrategy === 'author', 'text-gray-900 dark:text-gray-100': postsStrategy !== 'author' }">
                                    Attribute a post to each author
                                </span>
                                <span id="posts-strategy-0-description" class="block text-sm text-primary-600 dark:text-primary-400" :class="{ 'text-primary-600 dark:text-primary-400': postsStrategy === 'author', 'text-gray-600 dark:text-gray-400': postsStrategy !== 'author' }">
                                    A story post with 5 authors would attribute each author with 1 post (a total of 5 posts)
                                </span>
                            </div>
                        </label>

                        <label class="rounded-bl-md rounded-br-md relative border p-4 flex cursor-pointer focus:outline-none" :class="{ 'bg-primary-50 dark:bg-primary-900 border-primary-300 dark:border-primary-600 z-10': postsStrategy === 'post', 'border-gray-300 dark:border-gray-600': postsStrategy !== 'post' }">
                            <input type="radio" name="posts-strategy" value="post" class="shrink-0 h-4 w-4 mt-0.5 cursor-pointer border-gray-300 focus:ring-primary-500 bg-white focus:ring-offset-primary-50 dark:focus:ring-offset-primary-900" :class="{ 'text-primary-600 dark:text-primary-400': postsStrategy === 'author' }" aria-labelledby="posts-strategy-1-label" aria-describedby="posts-strategy-1-description" x-model="postsStrategy">
                            <div class="ml-3 flex flex-col">
                                <span id="posts-strategy-1-label" class="block text-sm font-medium" :class="{ 'text-primary-900 dark:text-primary-100': postsStrategy === 'post', 'text-gray-900 dark:text-gray-100': postsStrategy !== 'post' }">
                                    Attribute a single post
                                </span>
                                <span id="posts-strategy-1-description" class="block text-sm" :class="{ 'text-primary-600 dark:text-primary-400': postsStrategy === 'post', 'text-gray-600 dark:text-gray-400': postsStrategy !== 'post' }">
                                    A story post with 5 authors would attribute 1 post in total
                                </span>
                            </div>
                        </label>
                    </div>
                </fieldset>
            </x-form.section>

            <x-form.section title="Story post word count tracking" message="Track user activity based on the number of words in published posts." x-show="strategy === 'words'">
                <fieldset>
                    <legend class="sr-only">
                        Story Post Word Count Tracking
                    </legend>
                    <div class="bg-white dark:bg-gray-800 rounded-md -space-y-px">
                        <!-- Checked: "bg-indigo-50 border-indigo-200 z-10", Not Checked: "border-gray-200" -->
                        <label class="rounded-tl-md rounded-tr-md relative border p-4 flex cursor-pointer focus:outline-none" :class="{ 'bg-primary-50 dark:bg-primary-900 border-primary-300 dark:border-primary-600 z-10': wordCountStrategy === 'all', 'border-gray-300 dark:border-gray-600': wordCountStrategy !== 'all' }">
                            <input type="radio" name="word-count-strategy" value="all" class="shrink-0 h-4 w-4 mt-0.5 cursor-pointer  border-gray-300 focus:ring-primary-500 bg-white focus:ring-offset-primary-50 dark:focus:ring-offset-primary-900" :class="{ 'text-primary-600 dark:text-primary-400': wordCountStrategy === 'all' }" aria-labelledby="word-count-strategy-0-label" aria-describedby="word-count-strategy-0-description" x-model="wordCountStrategy">
                            <div class="ml-3 flex flex-col">
                                <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
                                <span id="word-count-strategy-0-label" class="block text-sm font-medium" :class="{ 'text-primary-900 dark:text-primary-100': wordCountStrategy === 'all', 'text-gray-900 dark:text-gray-100': wordCountStrategy !== 'all' }">
                                    Attribute all words to each author
                                </span>
                                <!-- Checked: "text-indigo-700", Not Checked: "text-gray-500" -->
                                <span id="word-count-strategy-0-description" class="block text-sm" :class="{ 'text-primary-600 dark:text-primary-400': wordCountStrategy === 'all', 'text-gray-600 dark:text-gray-400': wordCountStrategy !== 'all' }">
                                    A story post with 500 words and 2 authors would attribute 500 words to Author A and 500 words to Author B
                                </span>
                            </div>
                        </label>

                        <!-- Checked: "bg-indigo-50 border-indigo-200 z-10", Not Checked: "border-gray-200" -->
                        <label class="rounded-bl-md rounded-br-md relative border p-4 flex cursor-pointer focus:outline-none" :class="{ 'bg-primary-50 dark:bg-primary-900 border-primary-300 dark:border-primary-600 z-10': wordCountStrategy === 'average', 'border-gray-300 dark:border-gray-600': wordCountStrategy !== 'average' }">
                            <input type="radio" name="word-count-strategy" value="average" class="shrink-0 h-4 w-4 mt-0.5 cursor-pointer  border-gray-300 focus:ring-primary-500 bg-white focus:ring-offset-primary-50 dark:focus:ring-offset-primary-900" :class="{ 'text-primary-600 dark:text-primary-400': wordCountStrategy === 'average' }" aria-labelledby="word-count-strategy-1-label" aria-describedby="word-count-strategy-1-description" x-model="wordCountStrategy">
                            <div class="ml-3 flex flex-col">
                                <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
                                <span id="word-count-strategy-1-label" class="block text-sm font-medium" :class="{ 'text-primary-900 dark:text-primary-100': wordCountStrategy === 'average', 'text-gray-900 dark:text-gray-100': wordCountStrategy !== 'average' }">
                                    Attribute an average of words per author to each author
                                </span>
                                <!-- Checked: "text-indigo-700", Not Checked: "text-gray-500" -->
                                <span id="word-count-strategy-1-description" class="block text-sm" :class="{ 'text-primary-600 dark:text-primary-400': wordCountStrategy === 'average', 'text-gray-600 dark:text-gray-400': wordCountStrategy !== 'average' }">
                                    A story post with 500 words and 2 authors would attribute 250 words to Author A and 250 words to Author B
                                </span>
                            </div>
                        </label>
                    </div>
                </fieldset>

                <x-input.group label="Story post word count conversion">
                    <x-input.text
                        name="word-count-post-conversion"
                        value="{{ $settings->posting_activity->wordCountPostConversion }}"
                        leading-add-on="1 story post equals"
                        trailing-add-on="words"
                    />
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button-filled type="submit" form="posting">Save settings</x-button-filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
