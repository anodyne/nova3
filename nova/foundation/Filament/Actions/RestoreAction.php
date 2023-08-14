<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\RestoreAction as FilamentRestoreAction;

class RestoreAction extends FilamentRestoreAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(iconName('history'));

        $this->modalIcon(iconName('history'));
        $this->modalIconColor('primary');
    }
}
