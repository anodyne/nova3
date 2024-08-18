@props([
    'label' => null,
    'description' => null,
    'id' => null,
    'error' => null,
])

<div
    @class([
        'nova-field-group relative',
        '[&+[nova-field-group]]:mt-8',
        '[&>[data-slot=label]+[data-slot=control]]:mt-2',
        '[&>[data-slot=label]+[data-slot=description]]:mt-1',
        '[&>[data-slot=description]+[data-slot=control]]:mt-2',
        '[&>[data-slot=control]+[data-slot=description]]:mt-2',
        '[&>[data-slot=control]+[data-slot=error]]:mt-2',
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

    @if (filled($error))
        <div data-slot="error" class="nova-field-error flex items-center gap-x-1">
            <x-icon name="alert" size="sm" class="nova-field-error-icon text-danger-400 dark:text-danger-600"></x-icon>
            <div class="nova-field-error-message text-sm/6 font-medium text-danger-500">{{ $error }}</div>
        </div>
    @endif
</div>
