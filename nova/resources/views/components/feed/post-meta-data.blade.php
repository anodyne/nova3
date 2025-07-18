@props([
    'post',
])

@use('Nova\Foundation\Helpers\DateHelper')

<div
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-x-8 rounded-md bg-gray-800/5 dark:bg-white/10 px-3 py-1.5 text-sm ring-1 ring-inset ring-gray-950/5 dark:ring-white/5']) }}
>
    <x-metadata label="Reading time" :value="$post->reading_time"></x-metadata>

    <x-metadata label="Words" :value="$post->word_count"></x-metadata>

    @if (filled($post->published_at))
        <x-metadata label="Published" :value="DateHelper::formatDate($post->published_at)"></x-metadata>
    @endif

    @if ($post->postType->fields->rating->enabled)
        <x-metadata label="Content ratings">
            <div class="flex items-center gap-x-1">
                <x-rating.display size="xs" type="language" :rating="$post->rating_language"></x-rating.display>
                <x-rating.display size="xs" type="sex" :rating="$post->rating_sex"></x-rating.display>
                <x-rating.display size="xs" type="violence" :rating="$post->rating_violence"></x-rating.display>
            </div>
        </x-metadata>
    @endif
</div>
