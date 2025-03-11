<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;

abstract class Step
{
    abstract public function incompleteIcon(): string;

    abstract public function title(): string;

    abstract public function isComplete(): bool;

    abstract public function isCurrent(): bool;

    public function icon(): Htmlable
    {
        if ($this->isComplete()) {
            if (method_exists($this, 'completeClasses')) {
                /** @disregard P1013 Undefined method */
                $classes = $this->completeClasses();
            } else {
                $classes = 'size-6 fill-white text-success-500';
            }

            if (method_exists($this, 'completeIcon')) {
                /** @disregard P1013 Undefined method */
                $svgPaths = $this->completeIcon();
            } else {
                $svgPaths = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" />';
            }
        } else {
            if (method_exists($this, 'incompleteClasses')) {
                /** @disregard P1013 Undefined method */
                $classes = $this->incompleteClasses();
            } else {
                $classes = Arr::toCssClasses([
                    'size-6',
                    'text-gray-500' => ! $this->isCurrent(),
                    'text-primary-500' => $this->isCurrent(),
                ]);
            }

            $svgPaths = $this->incompleteIcon();
        }

        return new HtmlString('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="'.$classes.'">'.$svgPaths.'</svg>');
    }

    public function shouldShow(): bool
    {
        return true;
    }
}
