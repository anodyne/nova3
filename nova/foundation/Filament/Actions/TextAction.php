<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\Action;

class TextAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->view('filament.actions.text-action');
        $this->defaultColor('gray');
    }
}
