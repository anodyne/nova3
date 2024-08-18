@props([
    'initial',
])

<div
    {{
        $attributes->class([
            'nv-tabs',
        ])
    }}
    x-data="tabsList('{{ $initial }}')"
>
    <div class="nv-tabs-list">
        {{ $tabs }}
    </div>

    <div class="nv-tabs-content">
        {{ $slot }}
    </div>
</div>
