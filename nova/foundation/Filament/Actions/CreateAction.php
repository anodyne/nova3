<?php

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\CreateAction as FilamentCreateAction;

class CreateAction extends FilamentCreateAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('primary');
        $this->icon(iconName('add'));
        $this->iconSize('md');
    }
}
