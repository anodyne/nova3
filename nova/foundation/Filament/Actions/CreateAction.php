<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Support\Enums\Size;
use Nova\Foundation\Icons\Icon;

class CreateAction extends \Filament\Actions\CreateAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('primary');
        $this->icon(Icon::Plus);
        $this->size(Size::Medium);
    }
}
