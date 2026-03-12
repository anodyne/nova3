<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Nova\Foundation\Livewire\Concerns\ModalAttributes;
use Nova\Foundation\Livewire\Concerns\ModalBehaviors;
use WireElements\Pro\Components\Modal\Modal as BaseModal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

abstract class Modal extends BaseModal
{
    use InteractsWithConfirmationModal;
    use ModalAttributes;
    use ModalBehaviors;
}
