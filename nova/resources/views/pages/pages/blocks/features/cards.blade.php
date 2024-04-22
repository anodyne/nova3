<div
    @class([
        '@container',
        'nv-features nv-features-cards',
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

        <div class="@xs:mt-16 @lg:mt-20 space-y-3 @2xl:mt-24">
            @foreach ($rows as $row)
                <div class="@xs:grid-cols-1 grid gap-3 @2xl:grid-cols-3">
                    @foreach ($row->columns as $column)
                        <div
                            @class([
                                'flex flex-col overflow-hidden rounded-lg bg-gray-950/[.04] ring-1 ring-inset ring-gray-950/[.025] dark:bg-white/10 dark:ring-white/[.025]',
                                match (true) {
                                    $row->layout === 'md-sm' && $loop->first => 'col-span-2',
                                    $row->layout === 'md-sm' && $loop->last => 'col-span-1',
                                    $row->layout === 'sm-md' && $loop->first => 'col-span-1',
                                    $row->layout === 'sm-md' && $loop->last => 'col-span-2',
                                    $row->layout === 'sm' => 'col-span-1',
                                    default => 'col-span-3',
                                },
                            ])
                        >
                            <x-spacing class="flex-1" size="md">
                                @if ($heading = data_get($column, 'heading'))
                                    <h3
                                        class="font-[family-name:--font-header] text-lg/8 font-semibold text-gray-900 dark:text-white"
                                    >
                                        {{ $heading }}
                                    </h3>
                                @endif

                                @if ($description = data_get($column, 'description'))
                                    <div
                                        @class([
                                            'space-y-6 text-base/7 text-gray-600 dark:text-gray-300',
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
                                        'h-48' => $row->layout !== 'lg',
                                        'h-96' => $row->layout === 'lg',
                                    ])
                                />
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </x-public::block.wrapper>
</div>
