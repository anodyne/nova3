<div
    class="relative isolate overflow-hidden py-24 font-[family-name:--font-body] sm:py-32"
    @isset($backgroundColor)
        style="background-color:{{ $backgroundColor }}"
    @endisset
>
    <div class="relative z-10 mx-auto max-w-7xl px-6 lg:px-8">
        <div
            @class([
                'flex',
                'content-end justify-end' => $orientation === 'right',
            ])
        >
            <div
                @class([
                    'max-w-2xl',
                    'mx-auto lg:text-center' => $orientation === 'center',
                    'lg:text-right' => $orientation === 'right',
                ])
            >
                @if (filled($heading))
                    <h2
                        @class([
                            'nv-features-heading font-[family-name:--font-header] text-3xl font-bold tracking-tight sm:text-4xl',
                            'text-gray-900' => ! $dark,
                            'text-white' => $dark,
                        ])
                    >
                        {{ $heading }}
                    </h2>
                @endif

                @if (filled($description))
                    <div
                        @class([
                            'nv-features-description space-y-6 text-lg/8',
                            'text-gray-600' => ! $dark,
                            'text-gray-300' => $dark,
                            'mt-6' => filled($heading),
                        ])
                    >
                        {!! str($description)->markdown() !!}
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-16 space-y-3 sm:mt-20 lg:mt-24">
            @foreach ($rows as $row)
                <div class="grid grid-cols-1 gap-3 lg:grid-cols-3">
                    @foreach ($row['columns'] as $column)
                        <div
                            @class([
                                'overflow-hidden rounded-lg ring-1 ring-inset',
                                'bg-gray-950/[.04] ring-gray-950/[.025]' => ! $dark,
                                'bg-white/[.04] ring-white/[.025]' => $dark,
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
                                    <h3
                                        @class([
                                            'font-[family-name:--font-header] text-lg/8 font-semibold',
                                            'text-gray-900' => ! $dark,
                                            'text-white' => $dark,
                                        ])
                                    >
                                        {{ $heading }}
                                    </h3>
                                @endif

                                @if ($description = data_get($column, 'description'))
                                    <div
                                        @class([
                                            'space-y-6 text-base/7',
                                            'text-gray-600' => ! $dark,
                                            'text-gray-300' => $dark,
                                            'mt-1' => filled($heading),
                                        ])
                                    >
                                        {!! str($description)->markdown() !!}
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
