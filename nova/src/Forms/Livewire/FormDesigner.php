<?php

declare(strict_types=1);

namespace Nova\Forms\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconSize;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Nova\Forms\Actions\PublishFormManager;
use Nova\Forms\Actions\UnpublishForm;
use Nova\Forms\Actions\UpdateForm;
use Nova\Forms\Data\FormFieldsData;
use Nova\Forms\Fields\FormFieldRegistry;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\Form as NovaForm;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\FormComponent;

/**
 * @property-read Form $getNovaForm
 * @property-read Schema $form
 */
class FormDesigner extends FormComponent
{
    #[Locked]
    public NovaForm $novaForm;

    protected string $view = 'pages.forms.livewire.form-designer';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Builder::make('fields')
                    ->hiddenLabel()
                    ->blockPreviews(areInteractive: true)
                    ->blocks(FormFieldRegistry::fields())
                    ->collapsible()
                    ->addAction(fn (Action $action): Action => $action
                        ->label('Add field')
                        ->icon(Tabler::Plus)
                        ->iconSize(IconSize::Medium)
                        ->slideOver()
                        ->modalWidth(Width::ExtraLarge))
                    ->editAction(fn (Action $action): Action => $action
                        ->icon(Tabler::Settings)
                        ->slideOver()
                        ->modalWidth(Width::ExtraLarge))
                    ->afterStateUpdated(fn () => $this->save()),
            ])
            ->statePath('data')
            ->model($this->novaForm);
    }

    public function save(): void
    {
        $this->authorize('design', $this->novaForm);

        UpdateForm::run($this->novaForm, FormFieldsData::from($this->form->getState()));

        Notification::make()->success()
            ->title('Form design has been updated')
            ->body('This is an in progress draft and is not available for visitors and users to see and use until you have published it.')
            ->send();
    }

    public function publish(): void
    {
        $this->authorize('design', $this->novaForm);

        PublishFormManager::run($this->novaForm);

        Notification::make()->success()
            ->title('Form design has been published')
            ->body('This version of the form is now live for all visitors and users to see and use.')
            ->send();
    }

    public function unpublish(): void
    {
        $this->authorize('design', $this->novaForm);

        UnpublishForm::run($this->novaForm);

        Notification::make()->success()
            ->title('Form design has been un-published')
            ->body('This version of the form is no longer live.')
            ->send();
    }

    public function mount(NovaForm $novaForm): void
    {
        Cache::put(CacheKeys::FormDesignerForm->value, $novaForm->id);

        $this->form->fill($novaForm->toArray());
    }

    #[Computed]
    public function getNovaForm(): NovaForm
    {
        return $this->novaForm;
    }
}
