<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Anodyne\TablerIcons\Tabler;
use Filament\Support\Enums\Size;

class CreateAction extends \Filament\Actions\CreateAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('primary');
        $this->icon(Tabler::Plus);
        $this->size(Size::Medium);
    }
}
