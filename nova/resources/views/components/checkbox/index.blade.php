@php
    $icon = $attributes->get('icon');

    if ($icon && $icon instanceof BackedEnum) {
        $novaIcon = $icon;
    }
@endphp

<flux:checkbox {{ $attributes->merge(['data-slot' => 'control']) }}>
    @isset($novaIcon)
        <x-slot name="icon">
            <x-icon :name="$novaIcon" size="sm"></x-icon>
        </x-slot>
    @endisset
</flux:checkbox>
