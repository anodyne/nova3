@use('Nova\Pages\Enums\BoxShadow')
@use('Nova\Pages\Enums\ButtonSize')
@use('Nova\Pages\Enums\Radius')

@php
    $images = collect(data_get($block, 'media.images'))->flatten()->toArray();
@endphp

<x-public::block.container
    :$container
    :$content
    :$block
    class="nv-hero nv-hero-image-tiles"
    inner-class="flex flex-row gap-8"
>
    <x-slot name="trailing">
        <div
            @class([
                'relative mt-6 flex items-center gap-6',
                'justify-center' => data_get($content, 'orientation') === 'center',
                'flex-row-reverse' => data_get($content, 'orientation') === 'right',
            ])
        >
            @foreach (data_get($block, 'buttons') as $button)
                @php
                    $buttonSize = ButtonSize::tryFrom(data_get($button, 'size') ?? 'text');
                    $radius = Radius::tryFrom(data_get($button, 'radius') ?? 'none');
                    $shadow = BoxShadow::tryFrom(data_get($button, 'shadow') ?? 'none');
                @endphp

                <div
                    style="
                        --bg-color: {{ data_get($button, 'bg-color') }};
                        --text-color: {{ data_get($button, 'text-color') }};
                        --border-color: {{ data_get($button, 'border-color') }};
                    "
                >
                    <a
                        href="{{ data_get($button, 'url') }}"
                        target="{{ data_get($button, 'url-target') }}"
                        @class([
                            'flex items-center gap-1.5 bg-[--bg-color] text-[--text-color] transition hover:brightness-110',
                            'ring-1 ring-[--border-color]' => data_get($button, 'border-style') !== 'none',
                            'ring-inset' => data_get($button, 'border-style') === 'inner',
                            $buttonSize?->getTailwindClasses(),
                            $radius?->getTailwindClasses(),
                            $shadow?->getTailwindClasses(),
                        ])
                    >
                        <span>{{ data_get($button, 'text') }}</span>

                        @if (data_get($button, 'decoration') === 'arrow')
                            <span class="text-base/6" aria-hidden="true">&rarr;</span>
                        @endif

                        @if (data_get($button, 'decoration') === 'single-chevron')
                            <span class="text-base/6" aria-hidden="true">&rsaquo;</span>
                        @endif

                        @if (data_get($button, 'decoration') === 'double-chevron')
                            <span class="text-base/6" aria-hidden="true">&raquo;</span>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    </x-slot>

    <div class="nv-hero-image-wrapper order-last flex items-end">
        <div
            class="nv-hero-image-ctn @xs:mt-14 @xs:justify-end @xl:-mt-44 @xl:justify-start @xl:pl-20 flex gap-8 @4xl:mt-0 @4xl:pl-0"
        >
            @if (isset($images[0]))
                <div
                    class="@xs:pt-32 @xl:order-last @xl:pt-80 @xs:ml-auto @xl:ml-0 w-44 flex-none space-y-8 @4xl:order-none @4xl:pt-36 @6xl:pt-80"
                >
                    <div class="relative">
                        <img
                            src="{{ Storage::disk('media-pages')->url($images[0]) }}"
                            alt=""
                            class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                        />
                        <div
                            class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                        ></div>
                    </div>
                </div>
            @endif

            @if (isset($images[1]) || isset($images[2]))
                <div class="@xs:mr-auto @xl:mr-0 @xs:pt-52 w-44 flex-none space-y-8 @4xl:pt-36">
                    @if (isset($images[1]))
                        <div class="relative">
                            <img
                                src="{{ Storage::disk('media-pages')->url($images[1]) }}"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                    @endif

                    @if (isset($images[2]))
                        <div class="relative">
                            <img
                                src="{{ Storage::disk('media-pages')->url($images[2]) }}"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                    @endif
                </div>
            @endif

            @if (isset($images[3]) || isset($images[4]))
                <div class="@xs:pt-32 @xl:pt-0 w-44 flex-none space-y-8">
                    @if (isset($images[3]))
                        <div class="relative">
                            <img
                                src="{{ Storage::disk('media-pages')->url($images[3]) }}"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                    @endif

                    @if (isset($images[4]))
                        <div class="relative">
                            <img
                                src="{{ Storage::disk('media-pages')->url($images[4]) }}"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-public::block.container>
