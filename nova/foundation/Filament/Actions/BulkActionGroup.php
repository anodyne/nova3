<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Support\Enums\Size;
use Nova\Foundation\Icons\Icon;

class BulkActionGroup extends \Filament\Actions\BulkActionGroup
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(Icon::DotsVertical);
        $this->size(Size::Medium);
        $this->dropdownPlacement('bottom-end');
    }

    public function divided(): self
    {
        $this->dropdown(false);

        return $this;
    }
}
