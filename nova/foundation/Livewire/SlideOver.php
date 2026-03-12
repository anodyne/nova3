<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Nova\Foundation\Livewire\Concerns\ModalAttributes;
use Nova\Foundation\Livewire\Concerns\ModalBehaviors;
use WireElements\Pro\Components\SlideOver\SlideOver as BaseSlideOver;

abstract class SlideOver extends BaseSlideOver
{
    use ModalAttributes;
    use ModalBehaviors;
}
