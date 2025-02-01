<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use LivewireUI\Modal\ModalComponent as BaseModalComponent;

abstract class ModalComponent extends BaseModalComponent
{
    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }
}
