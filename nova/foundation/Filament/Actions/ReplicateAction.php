<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Anodyne\TablerIcons\Tabler;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;

class ReplicateAction extends \Filament\Actions\ReplicateAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(Tabler::Copy);
        $this->label('Duplicate');

        $this->successNotificationTitle(function (Model $record): string {
            return trans('messages.table.replicate-success', [
                'title' => $record->title,
                'label' => $this->getRecordTitle(),
            ]);
        });

        $this->failureNotificationTitle(function (Model $record): string {
            return trans('messages.table.replicate-failure', [
                'title' => $record->title,
                'label' => $this->getRecordTitle(),
            ]);
        });

        $this->modalWidth(Width::ExtraLarge);
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalSubmitActionLabel('Yes, duplicate it');
        $this->modalContent(fn (Model $record): View => view($this->modalContentView, [
            'record' => $record,
            'action' => $this,
        ]));
    }
}
