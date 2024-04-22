<div
    @class([
        '@container',
        'nv-features nv-features-grid',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $bgColor ?? 'transparent' }}"
>
    <x-public::block.wrapper
        :spacing-horizontal="$spacingHorizontal ?? null"
        :spacing-vertical="$spacingVertical ?? null"
    >
        <x-public::block.header
            :heading="$heading ?? null"
            :description="$description ?? null"
            :orientation="$headerOrientation"
        ></x-public::block.header>

        <div class="@xs:mt-16 @xs:max-w-2xl @lg:mt-20 mx-auto @2xl:mt-24 @2xl:max-w-none">
            <dl class="@xs:max-w-xl @xs:grid-cols-1 grid gap-x-8 gap-y-16 @2xl:max-w-none @2xl:grid-cols-3">
                @foreach ($features as $feature)
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base/7 font-semibold text-gray-900 dark:text-white">
                            @if (data_get($feature, 'icon'))
                                <x-icon :name="data_get($feature, 'icon')" size="lg" class="text-primary-500"></x-icon>
                            @endif

                            <span>{{ data_get($feature, 'heading') }}</span>
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base/7 text-gray-600 dark:text-gray-400">
                            <p class="flex-auto">
                                {{ data_get($feature, 'description') }}
                            </p>
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </x-public::block.wrapper>
</div>
