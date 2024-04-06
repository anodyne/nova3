@props([
    'options' => [],
])

@use('Nova\Foundation\Nova')

<div class="flex items-center rounded-lg px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-900">
    <div
        @class([
            'inline-flex gap-x-3',
            'items-center' => ! in_array('position', $options) && ! in_array('type', $options) && ! in_array('status', $options) && ! in_array('rank-image', $options),
        ])
    >
        <x-avatar :src="Nova::getAvatarUrl()" size="lg"></x-avatar>

        <div class="flex flex-col">
            <div class="flex items-center text-lg/7 font-medium text-gray-900 dark:text-white">Character name</div>
            <div class="text-sm/6 text-gray-600 dark:text-gray-400">Position name</div>

            <div class="mt-1">
                <x-badge color="primary">Primary</x-badge>
                <x-badge color="success">Active</x-badge>
            </div>
        </div>
    </div>
</div>
