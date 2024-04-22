@props([
    'src' => false,
    'size' => 'md',
    'initials' => false,
])

@use('Nova\Settings\Enums\AvatarShape')

<span
    data-slot="avatar"
    @class([
        'inline-grid align-middle *:col-start-1 *:row-start-1',
        'rounded-[20%] *:rounded-[20%]' => settings('appearance.avatarShape') === AvatarShape::Square,
        'rounded-full *:rounded-full' => settings('appearance.avatarShape') === AvatarShape::Circle,
        match ($size) {
            'xs' => 'size-8',
            'sm' => 'size-10',
            'lg' => 'size-16',
            'xl' => 'size-24',
            default => 'size-12'
        },
        $attributes->get('class'),
    ])
    {{ $attributes }}
>
    @if (filled($src))
        <img src="{{ $src }}" />
    @endif

    @if (blank($src) && filled($initials))
        <svg class="select-none fill-current text-[48px] font-medium uppercase" viewBox="0 0 100 100">
            <text
                x="50%"
                y="50%"
                alignment-baseline="middle"
                dominant-baseline="middle"
                text-anchor="middle"
                dy=".125em"
            >
                {{ $initials }}
            </text>
        </svg>
    @endif

    <span class="ring-1 ring-inset ring-black/5 dark:ring-white/5 forced-colors:outline" aria-hidden="true"></span>
</span>
