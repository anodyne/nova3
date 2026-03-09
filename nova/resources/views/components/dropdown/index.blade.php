@props([
    'trigger' => null,
    'placement' => 'bottom start',
])

@php
    [$position, $align] = explode(' ', $placement);
@endphp

<flux:dropdown :$position :$align>
    {{ $trigger }}

    <flux:menu {{ $attributes->class(['max-w-72']) }}>
        {{ $slot }}
    </flux:menu>
</flux:dropdown>
