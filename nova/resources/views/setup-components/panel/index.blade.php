@props([
    'variant' => 'panel',
    'color' => 'gray',
    'orientation' => 'vertical',
])

<div
    data-slot="{{ $variant }}"
    {{
        $attributes->class([
            'flex',

            'flex-col' => $orientation === 'vertical',

            // Panel
            'data-[slot=panel]:flex-1 data-[slot=panel]:rounded-xl data-[slot=panel]:bg-white data-[slot=panel]:ring-1',
            match ($color) {
                'danger' => 'data-[slot=panel]:ring-danger-200',
                'info' => 'data-[slot=panel]:ring-info-200',
                'primary' => 'data-[slot=panel]:ring-primary-200',
                'success' => 'data-[slot=panel]:ring-success-200',
                'warning' => 'data-[slot=panel]:ring-warning-200',
                default => 'data-[slot=panel]:ring-gray-200',
            } => $variant === 'panel',

            // Well
            'data-[slot=well]:rounded-xl data-[slot=well]:ring-1',
            match ($color) {
                'danger' => 'data-[slot=well]:bg-danger-50 data-[slot=well]:ring-danger-200',
                'info' => 'data-[slot=well]:bg-info-50 data-[slot=well]:ring-info-200',
                'primary' => 'data-[slot=well]:bg-primary-50 data-[slot=well]:ring-primary-200',
                'success' => 'data-[slot=well]:bg-success-50 data-[slot=well]:ring-success-200',
                'warning' => 'data-[slot=well]:bg-warning-50 data-[slot=well]:ring-warning-200',
                default => 'data-[slot=well]:bg-gray-50 data-[slot=well]:ring-gray-200',
            } => $variant === 'well',

            // Card
            'data-[slot=card]:rounded-xl data-[slot=card]:bg-white data-[slot=card]:shadow data-[slot=card]:ring-1 data-[slot=card]:ring-gray-950/5',

            // Inset panel
            'has-[>[data-slot=inset]]:p-1 data-[slot=inset]:rounded-[calc(theme(borderRadius.xl)-theme(spacing.1))] data-[slot=inset]:bg-white data-[slot=inset]:shadow data-[slot=inset]:ring-1 data-[slot=inset]:ring-gray-200',
        ])
    }}
>
    {{ $slot }}
</div>
