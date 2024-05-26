@props([
    'label' => null,
    'description' => null,
    'id' => null,
])

<div
    @class([
        'nova-field-group relative',
        '[&+[nova-field-group]]:mt-8',
        '[&>[data-slot=label]+[data-slot=control]]:mt-2',
        '[&>[data-slot=label]+[data-slot=description]]:mt-1',
        '[&>[data-slot=description]+[data-slot=control]]:mt-2',
        '[&>[data-slot=control]+[data-slot=description]]:mt-2',
        '[&>[data-slot=label]]:font-medium',
        '[&>[data-slot=control]]:w-full',
    ])
>
    @if (filled($label))
        <label
            class="nova-field-label block select-none text-base/6 text-gray-950 dark:text-white sm:text-sm/6"
            data-slot="label"
            for="{{ $id }}"
        >
            {{ $label }}
        </label>
    @endif

    @if (filled($description))
        <div
            class="nova-field-description text-base/6 text-gray-500 dark:text-gray-400 sm:text-sm/6"
            data-slot="description"
        >
            {{ $description }}
        </div>
    @endif

    {{ $slot }}
</div>
