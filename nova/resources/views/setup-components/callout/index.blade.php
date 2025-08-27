@props([
    'heading' => false,
])

<flux:callout :inline="! $heading" {{ $attributes->merge(['color' => 'gray']) }}>
    @if ($heading)
        <flux:callout.heading>{{ $heading }}</flux:callout.heading>
    @endif

    <flux:callout.text>
        {{ $slot }}
    </flux:callout.text>
</flux:callout>
