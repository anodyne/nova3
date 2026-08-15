<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire\Concerns;

trait ModalAttributes
{
    /**
     * Map of the supported sizes onto the Tailwind max-width utility that the
     * overlay uses to constrain the modal.
     *
     * @var array<string, string>
     */
    protected static array $sizeClasses = [
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
        'fullscreen' => 'max-w-full',
    ];

    /**
     * Exposed to the component's view so the modal chrome can size itself.
     */
    public function modalSize(): string
    {
        return static::size();
    }

    /**
     * The width of the modal, one of: xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl,
     * 6xl, 7xl, fullscreen.
     */
    public static function size(): string
    {
        return 'lg';
    }

    public static function sizeClass(): string
    {
        return static::$sizeClasses[static::size()] ?? static::$sizeClasses['lg'];
    }
}
