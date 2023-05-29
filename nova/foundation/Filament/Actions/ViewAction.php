<?php

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\ViewAction as FilamentViewAction;

class ViewAction extends FilamentViewAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(iconName('show'));
    }
}
