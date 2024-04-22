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

        <div class="mt-24 space-y-3">
            @foreach ($rows as $row)
                <div class="grid grid-cols-3 gap-3">
                    @foreach ($row['columns'] as $column)
                        <div
                            @class([
                                'flex flex-col overflow-hidden rounded-lg bg-gray-950/[.04] ring-1 ring-inset ring-gray-950/[.025] dark:bg-white/10 dark:ring-white/[.025]',
                                match (true) {
                                    $row['layout'] === 'md-sm' && $loop->first => 'col-span-2',
                                    $row['layout'] === 'md-sm' && $loop->last => 'col-span-1',
                                    $row['layout'] === 'sm-md' && $loop->first => 'col-span-1',
                                    $row['layout'] === 'sm-md' && $loop->last => 'col-span-2',
                                    $row['layout'] === 'sm' => 'col-span-1',
                                    default => 'col-span-3',
                                },
                            ])
                        >
                            <x-spacing class="flex-1" size="md">
                                @if ($heading = data_get($column, 'heading'))
                                    <h3 class="text-lg/8 font-semibold text-gray-900 dark:text-white">Heading</h3>
                                @endif

                                @if ($description = data_get($column, 'description'))
                                    <div
                                        @class([
                                            'space-y-6 text-base/7 text-gray-600 dark:text-gray-300',
                                            'mt-1' => filled($heading),
                                        ])
                                    >
                                        Commodo et non aliquip ad incididunt magna reprehenderit et adipisicing culpa
                                        officia.
                                    </div>
                                @endif
                            </x-spacing>

                            @if ($image = data_get($column, 'image'))
                                <img
                                    src="{{ asset('media/'.$image) }}"
                                    alt=""
                                    @class([
                                        'mx-auto mb-px block h-56 w-[calc(100%-2px)] rounded-b-lg object-cover',
                                        'h-48' => $row['layout'] !== 'lg',
                                        'h-96' => $row['layout'] === 'lg',
                                    ])
                                />
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
