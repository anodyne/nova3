@props([
    'height' => null,
    'width' => null,
    'size' => null,
    'top' => null,
    'bottom' => null,
    'left' => null,
    'right' => null,
    'constrained' => false,
    'constrainedLg' => false,
])

<div
    data-slot="container"
    @class([
        'relative w-full',
        match ($size) {
            'none' => 'p-0',
            '2xs' => 'p-1.5',
            'xs' => 'p-3',
            'sm' => 'p-4',
            'md' => 'p-6',
            'lg' => 'p-8',
            'xl' => 'p-12',
            default => null,
        } => filled($size),
        match ($height) {
            'none' => 'py-0',
            '2xs' => 'py-1.5',
            'xs' => 'py-3',
            'sm' => 'py-4',
            'md' => 'py-6',
            'lg' => 'py-8',
            'xl' => 'py-12',
            default => null,
        } => filled($height) && blank($size),
        match ($width) {
            'none' => 'px-0',
            '2xs' => 'px-1.5',
            'xs' => 'px-3',
            'sm' => 'px-4',
            'md' => 'px-6',
            'lg' => 'px-8',
            'xl' => 'px-12',
            default => null,
        } => filled($width) && blank($size),
        match ($top) {
            'none' => 'pt-0',
            '2xs' => 'pt-1.5',
            'xs' => 'pt-3',
            'sm' => 'pt-4',
            'md' => 'pt-6',
            'lg' => 'pt-8',
            'xl' => 'pt-12',
            default => null,
        } => filled($top) && blank($height) && blank($size),
        match ($bottom) {
            'none' => 'pb-0',
            '2xs' => 'pb-1.5',
            'xs' => 'pb-3',
            'sm' => 'pb-4',
            'md' => 'pb-6',
            'lg' => 'pb-8',
            'xl' => 'pb-12',
            default => null,
        } => filled($bottom) && blank($height) && blank($size),
        match ($left) {
            'none' => 'pl-0',
            '2xs' => 'pl-1.5',
            'xs' => 'pl-3',
            'sm' => 'pl-4',
            'md' => 'pl-6',
            'lg' => 'pl-8',
            'xl' => 'pl-12',
            default => null,
        } => filled($left) && blank($width) && blank($size),
        match ($right) {
            'none' => 'pr-0',
            '2xs' => 'pr-1.5',
            'xs' => 'pr-3',
            'sm' => 'pr-4',
            'md' => 'pr-6',
            'lg' => 'pr-8',
            'xl' => 'pr-12',
            default => null,
        } => filled($right) && blank($width) && blank($size),
        'mx-auto max-w-2xl' => $constrained,
        'mx-auto max-w-3xl' => $constrainedLg,
        $attributes->get('class') => $attributes->has('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</div>
