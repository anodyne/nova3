<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <div>
            <div
                @class([
                    'flex',
                    'content-end justify-end' => $headerOrientation === 'right',
                ])
            >
                <div
                    @class([
                        'max-w-2xl',
                        'mx-auto text-center' => $headerOrientation === 'center',
                        'text-right' => $headerOrientation === 'right',
                    ])
                >
                    @if (filled($heading))
                        <x-public::preview.h2>Heading</x-public::preview.h2>
                    @endif

                    @if (filled($description))
                        <x-public::preview.lead
                            @class([
                                'mt-6' => filled($heading),
                            ])
                            markdown
                        ></x-public::preview.lead>
                    @endif
                </div>
            </div>

            <div
                @class([
                    'grid grid-cols-3 gap-8',
                    'mt-10' => filled($heading) || filled($description),
                ])
            >
                @foreach (['language', 'sex', 'violence'] as $index => $rating)
                    <div
                        @class([
                            'rounded-xl ring-1 ring-inset',
                            match ($index) {
                                1 => match ($dark) {
                                    true => 'bg-yellow-950 text-yellow-300 ring-yellow-800',
                                    default => 'bg-yellow-50 text-yellow-700 ring-yellow-200'
                                },
                                2 => match ($dark) {
                                    true => 'bg-orange-950 text-orange-300 ring-orange-800',
                                    default => 'bg-orange-50 text-orange-700 ring-orange-200'
                                },
                                3 => match ($dark) {
                                    true => 'bg-red-950 text-red-300 ring-red-800',
                                    default => 'bg-red-50 text-red-700 ring-red-200'
                                },
                                default => match ($dark) {
                                    true => 'bg-green-950 text-green-300 ring-green-800',
                                    default => 'bg-green-50 text-green-700 ring-green-200'
                                },
                            },
                        ])
                    >
                        <x-spacing size="md" class="flex items-center gap-x-4">
                            <h3 class="font-[family-name:--font-header] text-5xl font-bold">
                                {{ $index }}
                            </h3>

                            <div class="text-sm/6">
                                <p class="font-semibold">{{ $rating }}</p>
                                <p>Lorem ipsum dolor amet</p>
                            </div>
                        </x-spacing>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
