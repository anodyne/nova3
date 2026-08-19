<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Anodyne\TablerIcons\Tabler;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;

class DeleteAction extends \Filament\Actions\DeleteAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(Tabler::Trash);

        $this->requiresConfirmation(false);

        $this->successNotificationTitle(fn (Model $record): string => trans('messages.table.delete-success', [
            'title' => $this->getRecordTitle($record),
            'label' => $this->getRecordTitle(),
        ]));

        $this->failureNotificationTitle(fn (Model $record): string => trans('messages.table.delete-failure', [
            'title' => $this->getRecordTitle($record),
            'label' => $this->getRecordTitle(),
        ]));

        $this->modalWidth(Width::Large);
        $this->modalIcon();
        $this->modalHeading('');
        $this->modalDescription();
        $this->modalSubmitActionLabel('Yes, delete it');
        $this->modalCancelActionLabel('No, keep it');
        $this->modalContent(fn (Model $record): View => view($this->modalContentView, [
            'record' => $record,
            'action' => $this,
        ]));
    }
}
