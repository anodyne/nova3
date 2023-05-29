<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\ForceDeleteAction as FilamentForceDeleteAction;

class ForceDeleteAction extends FilamentForceDeleteAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('danger');
        $this->icon(iconName('trash'));
    }
}
