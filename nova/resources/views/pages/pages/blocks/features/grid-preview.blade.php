<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <x-public::preview.block.header
            :heading="$heading ?? null"
            :description="$description ?? null"
            :orientation="$headerOrientation"
        ></x-public::preview.block.header>

        <div class="mx-auto mt-24">
            <dl class="grid grid-cols-3 gap-x-8 gap-y-16">
                @foreach ($features as $feature)
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base/7 font-semibold text-gray-900 dark:text-white">
                            @if (data_get($feature, 'icon'))
                                <x-icon :name="data_get($feature, 'icon')" size="lg" class="text-primary-500"></x-icon>
                            @endif

                            <span>Card heading</span>
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base/7 text-gray-600 dark:text-gray-400">
                            <p class="flex-auto">
                                Laborum consequat reprehenderit in aliquip ex nisi irure adipisicing laboris.
                            </p>
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</div>
