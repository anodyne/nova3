<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <div class="nv-stats-wrapper">
            @if (filled($heading) || filled($description))
                <div class="nv-stats-content-wrapper mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                    @if (filled($heading))
                        <x-public::preview.h2>Heading</x-public::preview.h2>
                    @endif

                    <div
                        @class([
                            'nv-stats-wrapper flex flex-col gap-x-8 gap-y-20 lg:flex-row',
                            'mt-6' => filled($heading),
                        ])
                    >
                        @if (filled($description))
                            <div class="nv-stats-content-ctn lg:w-full lg:max-w-2xl lg:flex-auto">
                                <x-public::preview.lead markdown>
                                    {{ $description }}
                                </x-public::preview.lead>
                            </div>
                        @endif

                        <div class="nv-stats-ctn flex flex-auto justify-center">
                            <dl class="space-y-8">
                                @foreach (['language', 'sex', 'violence'] as $index => $ratingType)
                                    <div class="flex items-center gap-x-3">
                                        <dd
                                            class="w-12 text-center font-[family-name:--font-header] text-5xl font-semibold tracking-tight text-gray-900 dark:text-white"
                                        >
                                            {{ $index }}
                                        </dd>
                                        <dt class="text-sm/6 text-gray-600 dark:text-white/60">
                                            <p class="font-semibold dark:text-white">{{ ucfirst($ratingType) }}</p>
                                            <p>Lorem ipsum dolor amet</p>
                                        </dt>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
