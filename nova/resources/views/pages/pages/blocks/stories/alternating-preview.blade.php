<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <div
            @class([
                'flex',
                'content-end justify-end' => $headerOrientation === 'right',
            ])
        >
            <div
                @class([
                    'max-w-2xl',
                    'mx-auto text-center' => $headerOrientation === 'center',
                    'text-right' => $headerOrientation === 'right',
                ])
            >
                @if (filled($heading))
                    <x-public::preview.h2>Heading</x-public::preview.h2>
                @endif

                @if (filled($description))
                    <x-public::preview.lead
                        @class([
                            'mt-6' => filled($heading),
                        ])
                        markdown
                    ></x-public::preview.lead>
                @endif
            </div>
        </div>

        <div class="mt-16 space-y-24">
            @foreach (['one', 'two'] as $story)
                <div class="flex gap-16">
                    <div
                        @class([
                            'w-full max-w-xl',
                            'order-last' => $loop->even,
                        ])
                    >
                        <x-public::preview.h2>Story title</x-public::preview.h2>

                        <x-public::preview.lead></x-public::preview.lead>

                        <div class="nv-cta-buttons-ctn mt-6 flex items-center">
                            <a
                                href="#"
                                @class([
                                    'nv-btn-primary rounded-lg px-3.5 py-2.5 text-center text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2',
                                    'nv-btn-primary-light bg-gray-800 text-white hover:bg-gray-950' => ! $dark,
                                    'nv-btn-primary-dark bg-white bg-opacity-75 text-gray-950 backdrop-blur hover:bg-opacity-100' => $dark,
                                ])
                            >
                                Go to story
                            </a>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-y-8">
                            <div class="border-l-2 border-gray-950/10 py-2 pl-6 dark:border-white/10">
                                <h3 class="text-base/7 text-gray-600 dark:text-gray-400">Total posts</h3>

                                <div
                                    class="order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl"
                                >
                                    100
                                </div>
                            </div>
                            <div class="border-l-2 border-gray-950/10 py-2 pl-6 dark:border-white/10">
                                <h3 class="text-base/7 text-gray-600 dark:text-gray-400">Total words</h3>

                                <div
                                    class="order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl"
                                >
                                    1,000
                                </div>
                            </div>

                            <div class="border-l-2 border-gray-950/10 py-2 pl-6 dark:border-white/10">
                                <h3 class="text-base/7 text-gray-600 dark:text-gray-400">
                                    Total posts (all stories within)
                                </h3>

                                <div
                                    class="order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl"
                                >
                                    100
                                </div>
                            </div>
                            <div class="border-l-2 border-gray-950/10 py-2 pl-6 dark:border-white/10">
                                <h3 class="text-base/7 text-gray-600 dark:text-gray-400">
                                    Total words (all stories within)
                                </h3>

                                <div
                                    class="order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl"
                                >
                                    1,000
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        @class([
                            'flex-1 shrink-0',
                            'order-first' => $loop->even,
                        ])
                    >
                        <img
                            src="https://picsum.photos/id/29/500/300"
                            alt=""
                            width="2432"
                            height="1442"
                            class="nv-hero-image h-auto w-[76rem] rounded-3xl shadow-2xl ring-1 ring-gray-900/10 dark:ring-white/10"
                        />
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
