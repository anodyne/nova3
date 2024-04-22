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
        <div class="nv-logos-wrapper @xs:grid-cols-1 grid items-center gap-x-8 gap-y-16 @2xl:grid-cols-2">
            <div class="nv-logos-content-ctn @xs:mx-auto w-full max-w-xl @2xl:mx-0">
                @if (filled($heading))
                    <x-public::h2>
                        {{ $heading }}
                    </x-public::h2>
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

            <div
                class="nv-logos-images-ctn @xs:mx-auto @xs:max-w-xl @xs:gap-y-12 grid w-full grid-cols-2 items-center @2xl:mx-0 @2xl:max-w-none @2xl:gap-y-14 @2xl:pl-8"
            >
                @foreach ($logos as $logo)
                    <a href="{{ $logo->url ?? '#' }}" target="_blank" rel="nofollow">
                        <img
                            class="max-h-12 w-full object-contain @2xl:object-left"
                            src="{{ asset('media/'.$logo->image) }}"
                            alt=""
                            width="105"
                            height="48"
                        />
                    </a>
                @endforeach
            </div>
        </div>
    </x-public::block.wrapper>
</div>
