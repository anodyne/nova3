<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read string $codeToCopy
 */
class CopyStacktraceButton extends Component
{
    public string $stacktrace;

    #[Computed]
    public function codeToCopy(): string
    {
        return str($this->stacktrace)->remove(base_path())->toString();
    }

    public function render(): string
    {
        return <<<'blade'
            <div
                class="flex items-center gap-x-2"
                x-data="{ copied: false }"
                x-init="$watch('copied', () => setTimeout(() => copied = false, 2000))"
            >
                <x-button
                    type="button"
                    x-clipboard.raw="{{ $this->codeToCopy }}"
                    x-on:click="copied = true"
                >
                    Copy stacktrace
                </x-button>

                <div
                    class="text-success-500 dark:text-success-500 text-sm/6 font-medium"
                    x-show="copied"
                    x-transition:enter="duration-200 ease-out"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="duration-100 ease-in"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-cloak
                >
                    Copied!
                </div>
            </div>
        blade;
    }
}
