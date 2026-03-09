@use('Filament\Support\Enums\ActionSize')
@use('Filament\Support\Enums\IconSize')

@php
    $icon = $getIcon();
    $size = $getSize();
    $color = $getColor();

    $iconClasses = \Illuminate\Support\Arr::toCssClasses([
        'fi-btn-icon transition duration-75 shrink-0',
        'h-5 w-5',
        'text-gray-400' => ($color === 'gray'),
    ]);
@endphp

<div
    class="fi-dropdown-list-item fi-ac-action fi-ac-grouped-action fi-ac-text-action items-start whitespace-normal hover:bg-transparent"
>
    @if ($icon)
        <x-filament::icon
            :attributes="
                \Filament\Support\prepare_inherited_attributes(
                    new \Illuminate\View\ComponentAttributeBag([
                        'icon' => $icon,
                    ])
                )->class([$iconClasses])
            "
        />
    @endif

    <span class="fi-dropdown-list-item-label whitespace-normal">
        {{ $getLabel() }}
    </span>
</div>
