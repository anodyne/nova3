@props([
    'actionsLeading' => null,
    'actionsTrailing' => null,
    'header' => null,
    'footer' => null,
    'input' => null,
])

<flux:composer {{ $attributes }}>
    @if ($header)
        <x-slot name="header">{{ $header }}</x-slot>
    @endif

    @if ($input)
        <x-slot name="input">{{ $input }}</x-slot>
    @endif

    @if ($actionsLeading)
        <x-slot name="actionsLeading">{{ $actionsLeading }}</x-slot>
    @endif

    @if ($actionsTrailing)
        <x-slot name="actionsTrailing">{{ $actionsTrailing }}</x-slot>
    @endif

    @if ($footer)
        <x-slot name="footer">{{ $footer }}</x-slot>
    @endif
</flux:composer>