@props([
    'maxHeight' => null,
    'offset' => 8,
    'placement' => null,
    'shift' => false,
    'teleport' => false,
    'trigger' => null,
    'width' => null,
])

<div
    x-data="{
        toggle: function (event) {
            $refs.panel.toggle(event)
        },
        open: function (event) {
            $refs.panel.open(event)
        },
        close: function (event) {
            $refs.panel.close(event)
        },
    }"
    x-on:keydown.window.escape="close"
    x-on:click.away="close"
    x-on:dropdown-toggle="toggle"
    x-on:dropdown-close.window="close"
    class="relative inline-block text-left leading-0"
>
    <div>
        @isset($trigger)
            <x-button.text
                tag="button"
                x-on:click="toggle"
                :color="$trigger->attributes->get('color', 'gray')"
                :leading="$trigger->attributes->get('leading')"
                :trailing="$trigger->attributes->get('trailing')"
            >
                {{ $trigger }}
            </x-button.text>
        @endisset

        @isset($emptyTrigger)
            <div role="button" x-on:click="toggle">
                {{ $emptyTrigger }}
            </div>
        @endisset
    </div>

    <div
        x-ref="panel"
        x-float{{ $placement ? ".placement.{$placement}" : '' }}.flip{{ $shift ? '.shift' : '' }}{{ $teleport ? '.teleport' : '' }}{{ $offset ? '.offset' : '' }}="{ offset: {{ $offset }} }"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:leave-end="opacity-0 scale-95"
        @if ($maxHeight)
            style="max-height: {{ $maxHeight }}"
        @endif
        @class([
            'absolute z-10 w-screen divide-y divide-gray-200 rounded-lg bg-white shadow-lg ring-1 ring-gray-900/5 transition dark:divide-gray-600/50 dark:bg-gray-800 dark:ring-white/20',
            match ($width) {
                'xs' => 'max-w-xs',
                'sm' => 'max-w-sm',
                'md' => 'max-w-md',
                'lg' => 'max-w-lg',
                'xl' => 'max-w-xl',
                '2xl' => 'max-w-2xl',
                '3xl' => 'max-w-3xl',
                '4xl' => 'max-w-4xl',
                '5xl' => 'max-w-5xl',
                '6xl' => 'max-w-6xl',
                '7xl' => 'max-w-7xl',
                null => 'max-w-[14rem]',
                default => $width,
            },
            'overflow-y-auto' => $maxHeight,
        ])
        x-cloak
    >
        {{ $slot }}
    </div>
</div>
