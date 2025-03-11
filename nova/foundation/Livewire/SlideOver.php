<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use WireElements\Pro\Components\SlideOver\SlideOver as BaseSlideOver;

abstract class SlideOver extends BaseSlideOver
{
    use Concerns\ModalAttributes;
    use Concerns\ModalBehaviors;
}
