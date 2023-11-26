@props([
    'post',
])

<div
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-x-8 text-sm']) }}
>
    <div class="flex items-center gap-x-1.5 text-gray-500">
        <span>Reading time</span>
        <span class="font-medium text-gray-600">{{ ceil($post->word_count / 200) }}m</span>
    </div>

    <div class="flex items-center gap-x-1.5 text-gray-500">
        <span>Words</span>
        <span class="font-medium text-gray-600">{{ $post->word_count }}</span>
    </div>

    <div class="flex items-center gap-x-1.5 text-gray-500">
        <span>Published</span>
        <span class="font-medium text-gray-600">
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
