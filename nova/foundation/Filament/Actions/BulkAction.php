<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\BulkAction as FilamentBulkAction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class BulkAction extends FilamentBulkAction
{
    use Concerns\HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->modalWidth(MaxWidth::Large);
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalContent(fn (Collection $records): View => view($this->modalContentView, [
            'records' => $records,
            'action' => $this,
        ]));
    }
}
