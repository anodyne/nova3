@props([
    'post',
])

<div
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-x-8 rounded-md bg-gray-50 dark:bg-white/5 px-3 py-1.5 text-sm ring-1 ring-inset ring-gray-950/5 dark:ring-white/5']) }}
>
    <div class="flex items-center gap-x-1.5 text-gray-500">
        <span>Reading time</span>
        <span class="font-medium text-gray-600 dark:text-gray-400">{{ ceil($post->word_count / 200) }}m</span>
    </div>

    <div class="flex items-center gap-x-1.5 text-gray-500">
        <span>Words</span>
        <span class="font-medium text-gray-600 dark:text-gray-400">{{ $post->word_count }}</span>
    </div>

    <div class="flex items-center gap-x-1.5 text-gray-500">
        <span>Published</span>
        <span class="font-medium text-gray-600 dark:text-gray-400">
            {{ format_date($post->published_at) }}
        </span>
    </div>

    @if ($post->postType->fields->rating->enabled)
        <div class="flex items-center gap-x-1.5 text-gray-500">
            <span>Content ratings</span>
            <div class="flex items-center gap-x-1">
                <x-rating.display size="xs" type="language" :rating="$post->rating_language"></x-rating.display>
                <x-rating.display size="xs" type="sex" :rating="$post->rating_sex"></x-rating.display>
                <x-rating.display size="xs" type="violence" :rating="$post->rating_violence"></x-rating.display>
            </div>
        </div>
    @endif
</div>
