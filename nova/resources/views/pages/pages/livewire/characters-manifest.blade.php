<div>
    @if ($showDepartments)
        @foreach ($departments as $department)
            <div class="mt-12 first:mt-0">
                @if ($department->hasMedia('header'))
                    <img src="{{ $department->getFirstMediaUrl('header') }}" class="h-8 w-auto" alt="" />
                @else
                    <h2
                        class="font-[family-name:--font-header] text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                    >
                        {{ $department->name }}
                    </h2>
                @endif

                @if ($layout === 'table')
                    <div class="mt-4">
                        @foreach ($department->positions as $position)
                            @if ($showCharacters)
                                @foreach ($position->characters as $character)
                                    <x-public::manifest.table-row
                                        :href="route('public.character-bio', $character)"
                                        :columns="$columns"
                                        :character="$character"
                                        :position="$position"
                                    ></x-public::manifest.table-row>
                                @endforeach
                            @endif

                            @if ($this->shouldShowAvailablePosition($position))
                                <x-public::manifest.table-row
                                    :href="route('public.join', $position->id)"
                                    :columns="$columns"
                                    :position="$position"
                                ></x-public::manifest.table-row>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if ($layout === 'grid')
                    <div class="@xs:grid-cols-1 @lg:grid-cols-2 mt-4 grid gap-8 @4xl:grid-cols-3">
                        @foreach ($department->positions as $position)
                            @foreach ($position->characters as $character)
                                <x-public::manifest.grid-item
                                    :href="route('public.character-bio', $character)"
                                    :character="$character"
                                    :position="$position"
                                    :options="$characterOptions ?? []"
                                ></x-public::manifest.grid-item>
                            @endforeach

                            @if ($this->shouldShowAvailablePosition($position))
                                <x-public::manifest.grid-item
                                    :href="route('public.join', $position->id)"
                                    :position="$position"
                                ></x-public::manifest.grid-item>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if ($layout === 'cards')
                    <div class="@xs:grid-cols-1 @lg:grid-cols-2 mt-4 grid gap-8 @4xl:grid-cols-3">
                        @foreach ($department->positions as $position)
                            @foreach ($position->characters as $character)
                                <x-public::manifest.card
                                    :href="route('public.character-bio', $character)"
                                    :character="$character"
                                    :position="$position"
                                    :orientation="$cardOrientation"
                                    :options="$characterOptions ?? []"
                                ></x-public::manifest.card>
                            @endforeach

                            @if ($showAvailablePositions && $position->available > 0)
                                <a
                                    href="{{ route('public.join', $position->id) }}"
                                    @class([
                                        'flex flex-col rounded-lg px-4 py-6 transition',
                                        'items-center' => $cardOrientation === 'center',
                                        'bg-white shadow ring-1 ring-gray-950/5 hover:shadow-lg' => ! $dark,
                                        'bg-gray-900 ring-1 ring-inset ring-white/5 hover:ring-white/10' => $dark,
                                    ])
                                >
                                    <div class="size-24"></div>

                                    <div
                                        @class([
                                            'mt-4 flex flex-col',
                                            'items-center' => $cardOrientation === 'center',
                                        ])
                                    >
                                        <div
                                            @class([
                                                'flex items-center text-lg/7 font-bold tracking-tight',
                                                'text-gray-900' => ! $dark,
                                                'text-white' => $dark,
                                            ])
                                        >
                                            {{ $position->name }}
                                        </div>
                                        <div
                                            @class([
                                                'text-sm/6',
                                                'text-gray-600' => ! $dark,
                                                'text-gray-400' => $dark,
                                            ])
                                        >
                                            Position available; apply now
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    @else
        @if ($layout === 'table')
            <div class="mt-4">
                @if ($showCharacters)
                    @foreach ($characters as $character)
                        <x-public::manifest.table-row
                            :href="route('public.character-bio', $character)"
                            :columns="$columns"
                            :character="$character"
                        ></x-public::manifest.table-row>
                    @endforeach
                @endif

                @if ($showAvailablePositions)
                    @foreach ($positions as $position)
                        @if ($this->shouldShowAvailablePosition($position))
                            <x-public::manifest.table-row
                                href="{{ route('public.join', $position->id) }}"
                                :columns="
                                    [
                                        ['column' => 'character-name', 'characterOptions' => [], 'width' => 'fill'],
                                    ]
                                "
                                :position="$position"
                            ></x-public::manifest.table-row>
                        @endif
                    @endforeach
                @endif
            </div>
        @endif

        @if ($layout === 'grid')
            <div class="@xs:grid-cols-1 @lg:grid-cols-2 mt-4 grid gap-8 @4xl:grid-cols-3">
                @if ($showCharacters)
                    @foreach ($characters as $character)
                        <x-public::manifest.grid-item
                            :href="route('public.character-bio', $character)"
                            :character="$character"
                            :options="$characterOptions ?? []"
                        ></x-public::manifest.grid-item>
                    @endforeach
                @endif

                @if ($showAvailablePositions)
                    @foreach ($positions as $position)
                        @if ($this->shouldShowAvailablePosition($position))
                            <x-public::manifest.grid-item
                                :href="route('public.join', $position->id)"
                                :position="$position"
                            ></x-public::manifest.grid-item>
                        @endif
                    @endforeach
                @endif
            </div>
        @endif

        @if ($layout === 'cards')
            <div class="@xs:grid-cols-1 @lg:grid-cols-2 mt-4 grid gap-8 @4xl:grid-cols-3">
                @if ($showCharacters)
                    @foreach ($characters as $character)
                        <x-public::manifest.card
                            :href="route('public.character-bio', $character)"
                            :character="$character"
                            :orientation="$cardOrientation"
                            :options="$characterOptions ?? []"
                        ></x-public::manifest.card>
                    @endforeach
                @endif

                @if ($showAvailablePositions)
                    @foreach ($positions as $position)
                        @if ($this->shouldShowAvailablePosition($position))
                            <x-public::manifest.card
                                :href="route('public.join', $position->id)"
                                :position="$position"
                            ></x-public::manifest.card>
                        @endif
                    @endforeach
                @endif
            </div>
        @endif
    @endif
</div>
