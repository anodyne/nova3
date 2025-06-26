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

<x-public::block.container
    :$container
    :$content
    :$block
    class="nv-logos nv-logos-split"
    inner-class="grid grid-cols-2 gap-8"
>
    <div class="nv-logos-images-ctn grid w-full grid-cols-2 items-center">
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
                    width="105"
                    height="48"
                />

                @if (data_get($logo, 'text') !== null)
                    <h3 class="text-base/7 font-medium text-[--logo-text-color]">
                        {{ data_get($logo, 'text') }}
                    </h3>
                @endif
            </a>
        @endforeach
    </div>
</x-public::block.container>
