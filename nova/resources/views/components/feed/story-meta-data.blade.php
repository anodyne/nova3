@props([
    'story',
])

<x-metadata.group
    gap="lg"
    {{ $attributes->merge(['class' => 'inline-flex rounded-md bg-gray-800/5 dark:bg-white/10 px-3 py-1.5 ring-1 ring-inset ring-gray-950/5 dark:ring-white/5']) }}
>
    <x-metadata
        :label="str('post')->plural($story->posts_count)->title()"
        :value="Number::format($story->posts_count)"
    ></x-metadata>

    <x-metadata
        :label="str('word')->plural($story->posts_sum_word_count)->title()"
        :value="Number::format($story->posts_sum_word_count ?? 0)"
    ></x-metadata>

    @mysql
        @if ($story->children_count > 0)
            <x-metadata label="Total posts within" :value="Number::format($story->recursive_posts_count)"></x-metadata>

            <x-metadata
                label="Total words within"
                :value="Number::format($story->recursive_posts_sum_word_count ?? 0)"
            ></x-metadata>
        @endif
    @endmysql
</x-metadata.group>
