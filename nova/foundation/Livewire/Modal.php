<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use WireElements\Pro\Components\Modal\Modal as BaseModal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

abstract class Modal extends BaseModal
{
    use Concerns\ModalAttributes;
    use Concerns\ModalBehaviors;
    use InteractsWithConfirmationModal;
}
