<div class="@container nv-manifest nv-manifest-departments">
    <div
        class="nv-manifest-wrapper relative isolate overflow-hidden font-[family-name:--font-body]"
        @isset($backgroundColor)
            style="background-color:{{ $backgroundColor }}"
        @endisset
    >
        <div class="nv-manifest-ctn @xs:px-6 @xl:px-8 @xs:py-8 @xl:py-16 mx-auto max-w-7xl">
            <div
                @class([
                    'nv-manifest-intro-wrapper flex',
                    'content-end justify-end' => $orientation === 'right',
                ])
            >
                <div
                    @class([
                        'nv-manifest-intro-ctn max-w-2xl',
                        'mx-auto @lg:text-center' => $orientation === 'center',
                        '@lg:text-right' => $orientation === 'right',
                    ])
                >
                    @if (filled($heading))
                        <h2
                            @class([
                                'nv-manifest-heading font-[family-name:--font-header] text-3xl font-bold tracking-tight sm:text-4xl',
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
                                'nv-manifest-description space-y-6 text-lg/8',
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

            <div
                @class([
                    'nv-manifest-content-wrapper',
                    'mt-12' => filled($heading) || filled($description),
                ])
            >
                <livewire:pages-department-manifest
                    :columns="$columns ?? null"
                    :dark="$dark"
                    :layout="$layout"
                    :card-orientation="$cardOrientation ?? null"
                    :department-status="$departmentStatus"
                    :selected-departments="$selectedDepartments ?? []"
                    :position-status="$positionStatus"
                    :selected-positions="$selectedPositions ?? []"
                    :show-available-positions="$showAvailablePositions ?? null"
                    :character-status="$characterStatus ?? null"
                    :character-type="$characterType ?? null"
                />
            </div>
        </div>
    </div>
</div>
