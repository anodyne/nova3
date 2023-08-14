<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions\Concerns;

trait HasModalContentView
{
    protected ?string $modalContentView = null;

    public function modalContentView(string $view): self
    {
        $this->modalContentView = $view;

        return $this;
    }
}
