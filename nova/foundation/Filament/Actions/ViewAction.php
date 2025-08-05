<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Support\Enums\Size;
use Nova\Foundation\Icons\Icon;

class ViewAction extends \Filament\Actions\ViewAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(Icon::Show);
        $this->size(Size::Medium);
    }
}
