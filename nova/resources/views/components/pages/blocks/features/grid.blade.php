@php
    $features = data_get($block, 'features') ?? [];
@endphp

<x-public::block.container :$container :$content :$block class="nv-features nv-features-grid">
    <div class="@xs:mt-16 @xs:max-w-2xl @lg:mt-20 mx-auto @2xl:mt-24 @2xl:max-w-none">
        <dl
            class="@xs:max-w-xl @xs:grid-cols-1 grid gap-x-8 gap-y-16 @2xl:max-w-none @2xl:grid-cols-3"
            style="
                --feature-icon-color: {{ data_get($block, 'icon-color') }};
                --feature-heading-color: {{ data_get($block, 'heading-color') }};
                --feature-description-color: {{ data_get($block, 'description-color') }};
            "
        >
            @foreach ($features as $feature)
                @php
                    $icon = Tabler::tryFrom(data_get($feature, 'icon'));
                @endphp

                <div class="flex flex-col">
                    <dt class="flex items-center gap-x-3 text-base/7 font-semibold">
                        @if ($icon)
                            <x-icon :name="$icon" size="lg" class="text-(--feature-icon-color)" />
                        @endif

                        <span class="text-(--feature-heading-color)">{{ data_get($feature, 'heading') }}</span>
                    </dt>
                    <dd class="mt-4 flex flex-auto flex-col text-base/7">
                        <p class="flex-auto text-(--feature-description-color)">
                            {{ data_get($feature, 'description') }}
                        </p>
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</x-public::block.container>
