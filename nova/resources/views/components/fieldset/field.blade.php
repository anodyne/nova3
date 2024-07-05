@props([
    'name',
    'id' => null,
    'label' => null,
    'description' => null,
    'error' => null,
])

@use('Illuminate\Support\Str')

@php
    $id = blank($id) ? Str::random(12) : $id;
@endphp

<div
    @class([
        '[&>[data-slot=label]+[data-slot=control]]:mt-3',
        '[&>[data-slot=label]+[data-slot=description]]:mt-1',
        '[&>[data-slot=label]+[data-slot=warning]]:mt-1',
        '[&>[data-slot=label]+[data-slot=text]]:mt-1',
        '[&>[data-slot=description]+[data-slot=control]]:mt-3',
        '[&>[data-slot=warning]+[data-slot=control]]:mt-3',
        '[&>[data-slot=info]+[data-slot=control]]:mt-3',
        '[&>[data-slot=control]+[data-slot=description]]:mt-3',
        '[&>[data-slot=control]+[data-slot=error]]:mt-3',
        '[&>[data-slot=control]+[data-slot=info]]:mt-3',
        '[&>[data-slot=label]]:font-medium',
    ])
    {{ $attributes }}
>
    @if (filled($label))
        <x-fieldset.label for="{{ $id }}">{{ $label }}</x-fieldset.label>
    @endif

    @if (filled($description))
        <x-fieldset.description>{{ $description }}</x-fieldset.description>
    @endif

    {{ $slot }}

    @if (filled($error))
        <div data-slot="error" class="flex items-center gap-x-1">
            <x-icon name="alert" size="sm" class="text-danger-400 dark:text-danger-600"></x-icon>
            <x-fieldset.error-message>{{ $error }}</x-fieldset.error-message>
        </div>
    @endif
</div>
