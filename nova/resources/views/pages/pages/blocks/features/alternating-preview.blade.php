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

        <div class="mt-24 space-y-24">
            @foreach ($features as $feature)
                <div class="flex gap-x-16">
                    <div
                        @class([
                            'max-w-xl',
                            'order-last' => $loop->even,
                        ])
                    >
                        @if (isset($feature['content']))
                            <div
                                @class([
                                    'prose prose-lg max-w-none',
                                    'dark:prose-invert',
                                ])
                            >
                                <h2>Heading</h2>
                                <p>
                                    Quis dolore duis nulla ullamco Lorem. Mollit do anim velit dolore irure et consequat
                                    tempor. Culpa sunt sunt qui et anim incididunt. Dolor minim laborum ad ex sunt
                                    adipisicing non qui dolore occaecat labore labore. Cillum dolore occaecat do ullamco
                                    anim esse aliqua. Commodo laborum elit mollit.
                                </p>
                            </div>
                        @endif
                    </div>

                    <div
                        @class([
                            'flex-1 overflow-hidden rounded-xl ring-1 ring-gray-950/5 dark:ring-white/5',
                            'order-first' => $loop->even,
                        ])
                    >
                        @if (isset($feature['image']) && filled($feature['image']))
                            <img
                                src="{{ asset('media/'.$feature['image']) }}"
                                alt=""
                                width="2432"
                                height="1442"
                                @class([
                                    'nv-hero-image w-[76rem] rounded-3xl shadow-2xl ring-1 ring-gray-900/10 dark:bg-white/5 dark:ring-white/10',
                                ])
                            />
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
