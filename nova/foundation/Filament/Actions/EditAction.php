<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\EditAction as FilamentEditAction;

class EditAction extends FilamentEditAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(iconName('edit'));
        $this->size('md');
    }
}
