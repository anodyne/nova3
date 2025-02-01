@props([
    'story',
])

@use('Illuminate\Support\Number')

<div
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-x-8 rounded-md bg-gray-50 dark:bg-white/5 px-3 py-1.5 text-sm ring-1 ring-inset ring-gray-950/5 dark:ring-white/5']) }}
>
    <x-metadata
        :label="str('post')->plural($story->posts_count)->title()"
        :value="Number::format($story->posts_count)"
    ></x-metadata>

    <x-metadata
        :label="str('word')->plural($story->posts_sum_word_count)->title()"
        :value="Number::format($story->posts_sum_word_count)"
    ></x-metadata>

    @mysql
        @if ($story->children_count > 0)
            <x-metadata label="Total posts within" :value="Number::format($story->recursive_posts_count)"></x-metadata>

            <x-metadata
                label="Total words within"
                :value="Number::format($story->recursive_posts_sum_word_count)"
            ></x-metadata>
        @endif
    @endmysql
</div>
