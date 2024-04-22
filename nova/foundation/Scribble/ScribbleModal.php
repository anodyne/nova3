<?php

declare(strict_types=1);

namespace Nova\Foundation\Scribble;

use Awcodes\Scribble\Livewire\ScribbleModal as BaseScribbleModal;

abstract class ScribbleModal extends BaseScribbleModal
{
    public function save(): void
    {
        $this->dispatch('saved-scribble-modal');

        parent::save();
    }
}
