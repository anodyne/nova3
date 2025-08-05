@props([
    'stories',
    'expanded' => false,
    'dotMask' => null,
])

<x-feed>
    @foreach ($stories as $story)
        @php
            $expandedState = true;

            if ($story->children_count > 0 && ! $expanded) {
                $expandedState = ! $story->is_completed;
            }
        @endphp

        <div
            @if ($story->children_count === 0)
                x-data="{ expanded: true }"
            @endif
            @if ($story->children_count > 0 && ! $expanded)
                x-data="{ expanded: @js(! $story->is_completed) }"
            @endif
        >
            <x-feed.item :class="$story->status->timelineMarker()" :dot-mask="$dotMask">
                <div
                    @class([
                        'flex w-full items-center justify-between',
                        'cursor-pointer' => $story->children_count > 0 && ! $expanded,
                    ])
                    @if ($story->children_count > 0 && ! $expanded)
                        x-on:click="expanded = !expanded"
                    @endif
                >
                    <div class="flex items-center gap-x-6">
                        <x-h2>{{ $story->title }}</x-h2>

                        <x-badge :color="$story->status->getColor()">
                            {{ $story->status->getLabel() }}
                        </x-badge>
                    </div>

                    @if ($story->children_count > 0 && ! $expanded)
                        <div class="shrink-0">
                            <span x-show="!expanded">
                                <x-icon
                                    :name="Icon::PlusCircle"
                                    size="md"
                                    class="text-gray-400 dark:text-gray-500"
                                ></x-icon>
                            </span>
                            <span x-show="expanded">
                                <x-icon
                                    :name="Icon::MinusCircle"
                                    size="md"
                                    class="text-gray-400 dark:text-gray-500"
                                ></x-icon>
                            </span>
                        </div>
                    @endif
                </div>

                <div
                    class="w-full"
                    @if ($story->children_count === 0 || ! $expanded)
                        x-show="expanded"
                        x-collapse
                        x-cloak
                    @endif
                >
                    <div
                        class="prose dark:prose-invert prose-a:text-primary-500 hover:prose-a:text-primary-600 dark:hover:prose-a:text-primary-400 max-w-4xl"
                    >
                        {!! $story->description !!}
                    </div>

                    <div class="relative mt-3">
                        <x-feed.story-meta-data :story="$story"></x-feed.story-meta-data>
                    </div>

                    <div class="mt-8">
                        <x-public::button :href="route('public.story', $story)">Go to story &rarr;</x-public::button>
                    </div>

                    @if ($story->children_count > 0)
                        <div class="relative mt-8 w-full">
                            <x-public::stories.timeline
                                :stories="$story->children"
                                :expanded="true"
                                :dot-mask="$dotMask"
                            ></x-public::stories.timeline>
                        </div>
                    @endif
                </div>
            </x-feed.item>
        </div>
    @endforeach
</x-feed>
