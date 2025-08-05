@php
    $logos = collect(data_get($block, 'logos'))
        ->values()
        ->map(function ($item) {
            if (is_array($item['image'])) {
                $item['image'] = collect($item['image'])->first();
            }

            return $item;
        })
        ->toArray();
@endphp

<x-public::block.container :$container :$content :$block class="nv-logos nv-logos-simple">
    <div
        @class([
            'nv-logos-images-ctn mx-auto grid items-center gap-y-10 @xs:max-w-lg @xs:grid-cols-2 @xs:gap-x-8 @xl:max-w-xl @xl:grid-cols-4 @xl:gap-x-10 @4xl:mx-0 @4xl:max-w-none',
            'mt-10' => data_get($content, 'heading.text') !== null,
        ])
    >
        @foreach ($logos as $logo)
            <a
                href="{{ data_get($logo, 'url') ?? '#' }}"
                target="_blank"
                rel="nofollow"
                class="flex flex-col items-center gap-2"
                style="--logo-text-color: {{ data_get($logo, 'text-color') }}"
            >
                <img
                    class="max-h-12 w-full object-contain"
                    src="{{ Storage::disk('media-pages')->url(data_get($logo, 'image')) }}"
                    alt=""
                    width="158"
                    height="48"
                />

                @if (data_get($logo, 'text') !== null)
                    <h3 class="text-base/7 font-medium text-(--logo-text-color)">
                        {{ data_get($logo, 'text') }}
                    </h3>
                @endif
            </a>
        @endforeach
    </div>
</x-public::block.container>
