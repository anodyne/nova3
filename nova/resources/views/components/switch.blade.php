@props([
    'name' => null,
    'align' => 'right',
    'size' => 'md',
])

@php
    // We only want to show the name attribute it has been set manually
    // but not if it has been set from the `wire:model` attribute...
    $showName = isset($name);
    if (! isset($name)) {
        $name = $attributes->whereStartsWith('wire:model')->first();
    }

    $classes = Flux::classes()
        ->add('group transition rounded-full shrink-0 flex items-center relative overflow-hidden')
        ->add(match ($size) {
            'sm' => 'w-8 h-4',
            'lg' => 'w-12 h-6',
            default => 'w-10 h-5',
        })
        ->add('bg-gray-200 dark:bg-gray-700 data-checked:bg-(--color-accent)')
        ->add('hover:bg-gray-200/80 dark:hover:bg-gray-700/80 data-checked:hover:bg-(--color-accent)/80 dark:data-checked-hover:bg-(--color-accent)/80')
        ->add('active:bg-gray-200/80 dark:active:bg-gray-700/80 active:scale-95 active:ease-in-out active:duration-200');

    $indicatorClasses = Flux::classes()
        ->add('shadow-sm ml-[0.125rem] flex origin-center rounded-full')
        ->add('transition [transition:margin_250ms]')
        ->add(match ($size) {
            'sm' => 'w-[1.03125rem] h-3 group-data-checked:ml-[calc(100%-1.15625rem)]',
            'lg' => 'w-[1.71875rem] h-5 group-data-checked:ml-[calc(100%-1.84375rem)]',
            default => 'w-[1.375rem] h-4 group-data-checked:ml-[calc(100%-1.5rem)]',
        })
        ->add('bg-white text-black');
@endphp

@if ($align === 'left' || $align === 'start')
    <flux:with-inline-field :$attributes>
        <ui-switch
            {{ $attributes->class($classes) }}
            @if($showName) name="{{ $name }}" @endif
            data-flux-control
            data-flux-switch
        >
            <span class="{{ \Illuminate\Support\Arr::toCssClasses($indicatorClasses) }}"></span>
        </ui-switch>
    </flux:with-inline-field>
@else
    <flux:with-reversed-inline-field :$attributes>
        <ui-switch
            {{ $attributes->class($classes) }}
            @if($showName) name="{{ $name }}" @endif
            data-flux-control
            data-flux-switch
        >
            <span class="{{ \Illuminate\Support\Arr::toCssClasses($indicatorClasses) }}"></span>
        </ui-switch>
    </flux:with-reversed-inline-field>
@endif
