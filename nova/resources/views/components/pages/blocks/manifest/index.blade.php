<x-public::block.container :$container :$content :$block class="nv-manifest">
    <div
        @class([
            'nv-content-wrapper',
            'mt-12' => filled($content, 'heading.text') || filled($content, 'message.text') || filled($content, 'callout.text'),
        ])
    >
        <livewire:pages-characters-manifest
            :show-available-positions="data_get($block, 'showAvailablePositions')"
            :show-characters="data_get($block, 'showCharacters')"
            :show-departments="data_get($block, 'showDepartments')"
            :layout="data_get($block, 'layout')"
            :columns="data_get($block, 'columns') ?? []"
            :character-options="data_get($block, 'characterOptions') ?? []"
            :card-orientation="data_get($block, 'cardOrientation') ?? null"
            :department-status="data_get($block, 'departmentStatus') ?? null"
            :selected-departments="data_get($block, 'selectedDepartments') ?? []"
            :tagged-departments="data_get($block, 'taggedDepartments') ?? []"
            :position-status="data_get($block, 'positionStatus') ?? null"
            :selected-positions="data_get($block, 'selectedPositions') ?? []"
            :tagged-positions="data_get($block, 'taggedPositions') ?? []"
            :available-positions-status="data_get($block, 'availablePositionsStatus') ?? null"
            :selected-available-positions="data_get($block, 'selectedAvailablePositions') ?? []"
            :tagged-available-positions="data_get($block, 'taggedAvailablePositions') ?? []"
            :character-status="data_get($block, 'characterStatus') ?? null"
            :character-type="data_get($block, 'characterType') ?? null"
        />
    </div>
</x-public::block.container>
