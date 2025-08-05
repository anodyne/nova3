<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Support\Enums\Size;
use Nova\Foundation\Icons\Icon;

class EditAction extends \Filament\Actions\EditAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(Icon::Edit);
        $this->size(Size::Medium);
    }
}
