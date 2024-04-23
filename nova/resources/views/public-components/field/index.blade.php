@props([
    'label' => null,
])

<div
    @class([
        'nova-form-field',
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
        '[&>[data-slot=control]]:w-full',
    ])
>
    @if (filled($label))
        <label data-slot="label">{{ $label }}</label>
    @endif

    {{ $slot }}
</div>
