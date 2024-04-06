@props([
    'orientation' => 'center',
    'options' => [],
])

@use('Nova\Foundation\Nova')

<div
    @class([
        'flex flex-col rounded-lg bg-white px-4 py-6 shadow ring-1 ring-gray-950/5 transition hover:shadow-lg dark:bg-gray-900 dark:ring-inset dark:ring-white/5 dark:hover:ring-white/10',
        'items-center' => $orientation === 'center',
    ])
>
    <x-avatar :src="Nova::getAvatarUrl()" size="xl"></x-avatar>

    <div
        @class([
            'mt-4 flex flex-col',
            'items-center' => $orientation === 'center',
        ])
    >
        <div class="flex items-center text-lg/7 font-bold tracking-tight text-gray-900 dark:text-white">
            Character name
        </div>
        <div class="text-sm/6 text-gray-600 dark:text-gray-400">Position name</div>

        <div class="mt-1">
            <x-badge color="success">Active</x-badge>
        </div>
    </div>
</div>
