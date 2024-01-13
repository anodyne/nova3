@props([
    'maxHeight' => null,
    'offset' => 8,
    'placement' => 'bottom-start',
    'shift' => false,
    'teleport' => false,
    'width' => null,
    'trigger' => null,
    'emptyTrigger' => null,
    'selectTrigger' => null,
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
            $nextTick(() => $refs.panel.close(event))
        },
    }"
    {{--
    x-on:keydown.window.escape="close"
    x-on:click.away="close"
--}}
    x-on:dropdown-toggle="toggle"
    x-on:dropdown-close="close"
    @class([
        'relative inline-block text-left leading-0',
        'w-full' => filled($selectTrigger),
    ])
    data-slot="control"
>
    <div>
        @isset($trigger)
            <x-button
                x-on:click="toggle"
                :color="$trigger->attributes->get('color', 'subtle-neutral')"
                :leading="$trigger->attributes->get('leading')"
                :trailing="$trigger->attributes->get('trailing')"
                text
            >
                {{ $trigger }}
            </x-button>
        @endisset

        @isset($emptyTrigger)
            <div role="button" x-on:click="toggle">
                {{ $emptyTrigger }}
            </div>
        @endisset

        @isset($selectTrigger)
            <div
                @class([
                    // Basic layout
                    'group relative block w-full',

                    // Background color + shadow applied to inset pseudo element, so shadow blends with border in light mode
                    'before:absolute before:inset-px before:rounded-[calc(theme(borderRadius.lg)-1px)] before:bg-white before:shadow',

                    // Background color is moved to control and shadow is removed in dark mode so hide `before` pseudo
                    'dark:before:hidden',

                    // Focus ring
                    'after:pointer-events-none after:absolute after:inset-0 after:rounded-lg after:ring-inset after:ring-transparent sm:after:focus-within:ring-2 sm:after:focus-within:ring-primary-500',

                    // Disabled state
                    'has-[[data-disabled]]:opacity-50 before:has-[[data-disabled]]:bg-gray-950/5 before:has-[[data-disabled]]:shadow-none',
                ])
            >
                <button
                    x-on:click="toggle"
                    type="button"
                    @class([
                        // Basic layout
                        'relative block w-full appearance-none rounded-lg py-[calc(theme(spacing[2.5])-1px)] sm:py-[calc(theme(spacing[1.5])-1px)]',

                        // Horizontal padding
                        'pl-[calc(theme(spacing[3.5])-1px)] pr-[calc(theme(spacing.10)-1px)] sm:pl-[calc(theme(spacing.3)-1px)] sm:pr-[calc(theme(spacing.9)-1px)]',

                        // Options (multi-select)
                        '[&_optgroup]:font-semibold',

                        // Typography
                        'text-left text-base/6 text-gray-950 placeholder:text-gray-500 sm:text-sm/6 dark:text-white',

                        // Border
                        'border border-gray-950/10 hover:border-gray-950/20 dark:border-white/10 dark:hover:border-white/20',

                        // Background color
                        'bg-transparent dark:bg-white/5',

                        // Hide default focus styles
                        'focus:outline-none focus:ring-0',

                        // Invalid state
                        'invalid:border-danger-500 invalid:hover:border-danger-500 invalid:dark:border-danger-600 invalid:hover:dark:border-danger-600',

                        // Disabled state
                        'disabled:border-gray-950/20 disabled:opacity-100 disabled:dark:border-white/15 disabled:dark:bg-white/[2.5%] dark:hover:disabled:border-white/15',
                    ])
                    aria-haspopup="true"
                    {{-- aria-expanded="true" --}}
                    {{-- x-bind:aria-expanded="open" --}}
                >
                    {{ $selectTrigger }}

                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                        <svg
                            class="size-5 stroke-gray-500 group-has-[[data-disabled]]:stroke-gray-600 sm:size-4 dark:stroke-gray-400 forced-colors:stroke-[CanvasText]"
                            viewBox="0 0 16 16"
                            aria-hidden="true"
                            fill="none"
                        >
                            <path
                                d="M5.75 10.75L8 13L10.25 10.75"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M10.25 5.25L8 3L5.75 5.25"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </span>
                </button>
            </div>
        @endisset
    </div>

    <div
        x-cloak
        x-float{{ $placement ? ".placement.{$placement}" : '' }}.flip{{ $shift ? '.shift' : '' }}{{ $teleport ? '.teleport' : '' }}{{ $offset ? '.offset' : '' }}="{ offset: {{ $offset }} }"
        x-ref="panel"
        x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0"
        @if ($attributes->has('wire:key'))
            wire:ignore.self
            wire:key="{{ $attributes->get('wire:key') }}.panel"
        @endif
        @class([
            'absolute isolate z-10 w-screen divide-y divide-gray-950/5 rounded-lg bg-white shadow-lg ring-1 ring-gray-950/5 transition dark:divide-white/5 dark:bg-gray-800 dark:ring-white/20',
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
            match ($placement) {
                'bottom-start' => 'origin-top-left transform',
                'bottom-end' => 'origin-top-right transform',
                default => null
            },
            'overflow-y-auto' => $maxHeight,
        ])
        @style([
            "max-height: {$maxHeight}" => $maxHeight,
        ])
        {{ $attributes }}
    >
        {{ $slot }}
    </div>
</div>
