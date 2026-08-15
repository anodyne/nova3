<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Livewire\Component;
use Nova\Foundation\Livewire\Concerns\ClosesModal;
use Nova\Foundation\Livewire\Concerns\ModalAttributes;

abstract class SlideOver extends Component
{
    use ClosesModal;
    use ModalAttributes;
}
