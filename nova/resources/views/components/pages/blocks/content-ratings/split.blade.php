@use('Nova\Stories\Enums\ContentRatingValue')

<x-public::block.container
    :$container
    :$content
    class="nv-ratings nv-ratings-split"
    inner-class="grid grid-cols-2 gap-8"
>
    <x-slot name="afterHeader">
        <div class="nv-stats-ctn">
            <dl class="space-y-8">
                @foreach (['language', 'sex', 'violence'] as $ratingType)
                    @php($rating = settings("ratings.{$ratingType}"))

                    <div class="flex items-center gap-x-3">
                        <dd
                            class="w-12 text-center font-[family-name:--font-header] text-5xl font-semibold tracking-tight text-gray-900 dark:text-white"
                        >
                            {{ $rating->rating->value }}
                        </dd>
                        <dt class="text-sm/6 text-gray-600 dark:text-white/60">
                            <p class="font-semibold dark:text-white">{{ ucfirst($ratingType) }}</p>
                            <p>{{ $rating->getDescription() }}</p>
                        </dt>
                    </div>
                @endforeach
            </dl>
        </div>
    </x-slot>
</x-public::block.container>
