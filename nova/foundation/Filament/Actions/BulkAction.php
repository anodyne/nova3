<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Support\Enums\Width;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;

class BulkAction extends \Filament\Actions\BulkAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->modalWidth(Width::Large);
        $this->modalIcon();
        $this->modalHeading('');
        $this->modalDescription();
        $this->modalContent(fn (Collection $records): View => view($this->getModalContentView(), [
            'records' => $records,
            'action' => $this,
        ]));
    }
}
