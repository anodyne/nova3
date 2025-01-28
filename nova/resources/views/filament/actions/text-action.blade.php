@use('Filament\Support\Enums\ActionSize')
@use('Filament\Support\Enums\IconSize')

@php
    $icon = $getIcon();
    $size = $getSize();
    $color = $getColor();

    $iconClasses = \Illuminate\Support\Arr::toCssClasses([
        'fi-btn-icon transition duration-75 shrink-0',
        'h-5 w-5',
        'text-gray-500 dark:text-gray-500' => ($color === 'gray'),
    ]);
@endphp

<div
    class="fi-dropdown-list-item fi-dropdown-list-item-color-gray fi-color-gray fi-ac-action fi-ac-grouped-action fi-ac-text-action flex w-full gap-2 whitespace-normal p-2 text-sm/6 !font-normal"
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

    {{ $getLabel() }}
</div>
