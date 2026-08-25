<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions\Concerns;

use LogicException;

trait HasModalContentView
{
    /** @var view-string|null */
    protected ?string $modalContentView = null;

    /** @param view-string $view */
    public function modalContentView(string $view): self
    {
        $this->modalContentView = $view;

        return $this;
    }

    /** @return view-string The configured modal content view. */
    protected function getModalContentView(): string
    {
        if ($this->modalContentView === null) {
            throw new LogicException('A modal content view must be configured before rendering the action.');
        }

        return $this->modalContentView;
    }
}
