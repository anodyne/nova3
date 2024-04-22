@props([
    'columns' => [],
])

@use('Nova\Foundation\Nova')
@use('Nova\Ranks\Models\RankItem')

<div class="flex items-center gap-x-4 rounded-lg px-3 py-3 transition hover:bg-gray-50 dark:hover:bg-gray-900">
    @foreach ($columns as $column)
        <div
            @class([
                'flex items-center',
                'flex-1' => $column['width'] === 'fill',
            ])
            @style([
                "width:{$column['width']}" => $column['width'] !== 'fit' && $column['width'] !== 'fill',
            ])
        >
            @if ($column['column'] === 'rank-image')
                <x-rank :rank="RankItem::inRandomOrder()->first()"></x-rank>
            @endif

            @if ($column['column'] === 'rank-name')
                Rank name
            @endif

            @if ($column['column'] === 'position-name')
                Position name
            @endif

            @if ($column['column'] === 'character-name')
                <div class="inline-flex items-center gap-x-3">
                    @if (in_array('avatar', $column['characterOptions']))
                        <x-avatar :src="Nova::getAvatarUrl()"></x-avatar>
                    @endif

                    <div class="flex flex-col">
                        <div class="flex items-center font-medium text-gray-900 dark:text-white">Character name</div>

                        @if (in_array('position', $column['characterOptions']))
                            <div class="text-sm/6 text-gray-600 dark:text-gray-400">Position name</div>
                        @endif
                    </div>
                </div>
            @endif

            @if ($column['column'] === 'character-type')
                <x-badge color="primary">Primary</x-badge>
            @endif

            @if ($column['column'] === 'character-status')
                <x-badge color="success">Active</x-badge>
            @endif
        </div>
    @endforeach
</div>
