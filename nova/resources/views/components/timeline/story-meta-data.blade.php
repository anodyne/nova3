@props([
    'story',
])

<div
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-x-8 rounded-md bg-gray-50 dark:bg-white/5 px-3 py-1.5 text-sm ring-1 ring-inset ring-gray-950/5 dark:ring-white/5']) }}
>
    <div class="flex items-center gap-x-1.5 text-gray-500">
        <span>{{ str('post')->plural($story->posts_count)->title() }}</span>
        <span class="font-medium text-gray-600 dark:text-gray-400">
            {{ number_format((int) $story->posts_count) }}
        </span>
    </div>

    <div class="flex items-center gap-x-1.5 text-gray-500">
        <span>{{ str('word')->plural($story->posts_sum_word_count)->title() }}</span>
        <span class="font-medium text-gray-600 dark:text-gray-400">
            {{ number_format((int) $story->posts_sum_word_count) }}
        </span>
    </div>

    @if ($story->children_count > 0)
        <div class="flex items-center gap-x-1.5 text-gray-500">
            <span>Total posts within</span>
            <span class="font-medium text-gray-600 dark:text-gray-400">
                {{ number_format((int) $story->recursive_posts_count) }}
            </span>
        </div>

        <div class="flex items-center gap-x-1.5 text-gray-500">
            <span>Total words within</span>
            <span class="font-medium text-gray-600 dark:text-gray-400">
                {{ number_format((int) $story->recursive_posts_sum_word_count) }}
            </span>
        </div>
    @endif
</div>
