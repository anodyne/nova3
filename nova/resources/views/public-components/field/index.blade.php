@props([
    'label' => null,
    'description' => null,
    'id' => null,
    'error' => null,
    'required' => null,
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
            class="nova-field-label block text-base/6 text-gray-950 select-none sm:text-sm/6 dark:text-white"
            data-slot="label"
            @isset($id)
                for="{{ $id }}"
            @endisset
        >
            {{ $label }}
            @if ($required)
                <span class="nova-field-label-required text-danger-500 font-semibold">*</span>
            @endif
        </label>
    @endif

    @if (filled($description))
        <div
            class="nova-field-description text-base/6 text-gray-500 sm:text-sm/6 dark:text-gray-400"
            data-slot="description"
        >
            {{ $description }}
        </div>
    @endif

    {{ $slot }}

    @if (filled($error))
        <div data-slot="error" class="nova-field-error flex items-center gap-x-1">
            <x-icon
                :name="Tabler::AlertCircle"
                size="sm"
                class="nova-field-error-icon text-danger-400 dark:text-danger-600"
            />
            <div class="nova-field-error-message text-danger-500 text-sm/6 font-medium">
                {{ $error }}
            </div>
        </div>
    @endif
</div>
