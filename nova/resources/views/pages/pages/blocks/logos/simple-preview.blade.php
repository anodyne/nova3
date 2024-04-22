<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <div class="nv-logos-wrapper">
            @if (filled($heading) || filled($description))
                <div
                    @class([
                        'nv-logos-content-wrapper max-w-2xl',
                        'mx-auto' => $headerOrientation === 'center',
                        'ml-auto' => $headerOrientation === 'right',
                    ])
                >
                    <div
                        @class([
                            'nv-logos-content-ctn',
                            'text-center' => $headerOrientation === 'center',
                            'text-right' => $headerOrientation === 'right',
                        ])
                    >
                        @if (filled($heading))
                            <x-public::preview.h2>Heading</x-public::preview.h2>
                        @endif

                        @if (filled($description))
                            <x-public::preview.lead
                                @class([
                                    'mt-4' => filled($heading),
                                ])
                                markdown
                            >
                                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ullam quis placeat facere
                                quibusdam nihil eum illum quas eaque nisi, quam sit velit consectetur explicabo ab
                                repellendus quos iure unde sapiente.
                            </x-public::preview.lead>
                        @endif
                    </div>
                </div>
            @endif

            <div
                @class([
                    'nv-logos-images-ctn mx-auto grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-10',
                    'mt-10' => filled($heading),
                ])
            >
                @foreach ($logos as $logo)
                    <x-icon name="image" class="h-12 w-12 object-contain text-gray-500"></x-icon>
                @endforeach
            </div>
        </div>
    </div>
</div>
