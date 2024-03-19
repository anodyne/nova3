<div
    @class([
        '@container',
        'nv-logos nv-logos-simple',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $bgColor ?? 'transparent' }}"
>
    <x-public::block.wrapper
        :spacing-horizontal="$spacingHorizontal ?? null"
        :spacing-vertical="$spacingVertical ?? null"
    >
        <div class="nv-logos-wrapper @xs:px-6 @lg:px-8 relative z-10 mx-auto max-w-7xl">
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
                            'nv-logos-ctn',
                            'text-center' => $headerOrientation === 'center',
                            'text-right' => $headerOrientation === 'right',
                        ])
                    >
                        @if (filled($heading))
                            <x-public::h2>{{ $heading }}</x-public::h2>
                        @endif

                        @if (filled($description))
                            <x-public::lead
                                @class([
                                    'mt-4' => filled($heading),
                                ])
                                markdown
                            >
                                {{ $description }}
                            </x-public::lead>
                        @endif
                    </div>
                </div>
            @endif

            <div
                @class([
                    'nv-logos-image-ctn mx-auto grid items-center gap-y-10 @xs:max-w-lg @xs:grid-cols-2 @xs:gap-x-8 @xl:max-w-xl @xl:grid-cols-4 @xl:gap-x-10 @4xl:mx-0 @4xl:max-w-none',
                    'mt-10' => filled($heading),
                ])
            >
                @foreach ($logos as $logo)
                    <a href="{{ $logo->url ?? '#' }}" target="_blank" rel="nofollow">
                        <img
                            class="max-h-12 w-full object-contain"
                            src="{{ asset('media/'.$logo->image) }}"
                            alt=""
                            width="158"
                            height="48"
                        />
                    </a>
                @endforeach
            </div>
        </div>
    </x-public::block.wrapper>
</div>
