<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class BulkAction extends \Filament\Actions\BulkAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->modalWidth(Width::Large);
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalContent(fn (Collection $records): View => view($this->modalContentView, [
            'records' => $records,
            'action' => $this,
        ]));
    }
}
