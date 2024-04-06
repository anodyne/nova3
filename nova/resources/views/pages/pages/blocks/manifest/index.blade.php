<div
    @class([
        '@container',
        'nv-manifest',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $backgroundColor ?? 'transparent' }}"
>
    <x-public::block.wrapper>
        <div class="nv-ctn @xs:px-6 @xl:px-8 @xs:py-8 @xl:py-16 mx-auto max-w-7xl">
            <x-public::block.header
                :orientation="$headerOrientation"
                :heading="$heading"
                :description="$description"
            ></x-public::block.header>

            <div
                @class([
                    'nv-content-wrapper',
                    'mt-12' => filled($heading) || filled($description),
                ])
            >
                <livewire:pages-characters-manifest
                    :show-available-positions="$showAvailablePositions"
                    :show-characters="$showCharacters"
                    :show-departments="$showDepartments"
                    :layout="$layout"
                    :columns="$columns ?? []"
                    :character-options="$characterOptions ?? []"
                    :card-orientation="$cardOrientation ?? null"
                    :department-status="$departmentStatus ?? null"
                    :selected-departments="$selectedDepartments ?? []"
                    :position-status="$positionStatus ?? null"
                    :selected-positions="$selectedPositions ?? []"
                    :available-positions-status="$availablePositionsStatus ?? null"
                    :selected-available-positions="$selectedAvailablePositions ?? []"
                    :character-status="$characterStatus ?? null"
                    :character-type="$characterType ?? null"
                />
            </div>
        </div>
    </x-public::block.wrapper>
</div>
