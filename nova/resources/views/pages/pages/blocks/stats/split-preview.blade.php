<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <div class="nv-stats-wrapper">
            @if (filled($heading) || filled($description))
                <div class="nv-stats-content-wrapper @xs:mx-auto @xs:max-w-2xl @xl:mx-0 @xl:max-w-none">
                    @if (filled($heading))
                        <x-public::preview.h2>{{ $heading }}</x-public::preview.h2>
                    @endif

                    <div
                        @class([
                            'nv-stats-wrapper flex gap-x-8 gap-y-20 @xs:flex-col @2xl:flex-row',
                            'mt-6' => filled($heading),
                        ])
                    >
                        @if (filled($description))
                            <div class="max-w-2xl">
                                <x-public::preview.lead markdown>
                                    {{ $description }}
                                </x-public::preview.lead>
                            </div>
                        @endif

                        <div class="nv-stats-ctn @2xl:flex @2xl:flex-auto @2xl:justify-center">
                            <dl class="@xs:w-64 space-y-8 @2xl:w-80">
                                @foreach ($stats as $stat)
                                    <div class="flex flex-col-reverse gap-y-4">
                                        <dt class="text-base/7 text-gray-600 dark:text-gray-300">Heading</dt>
                                        <dd class="text-5xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            3
                                        </dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
