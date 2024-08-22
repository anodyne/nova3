<?php

declare(strict_types=1);

namespace Nova\Forms\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Actions\SyncFormSubmissionResponses;
use Nova\Forms\Actions\UpdateFormSubmission;
use Nova\Forms\Enums\FormMode;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Mail\SendNewFormSubmission;
use Nova\Forms\Mail\SendUpdatedFormSubmission;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Forms\Models\FormSubmissionResponse;
use Nova\Foundation\Filament\Notifications\Notification;

class DynamicForm extends Component
{
    public Form $form;

    public ?Model $owner = null;

    public ?FormSubmission $submission = null;

    public bool $admin = false;

    public bool $static = false;

    public array $values = [];

    #[Computed]
    public function fields()
    {
        return $this->form->fields;
    }

    #[Computed]
    public function mode(): FormMode
    {
        if ($this->static) {
            return FormMode::View;
        }

        return filled($this->submission)
            ? FormMode::Edit
            : FormMode::Create;
    }

    #[Computed]
    public function showsFormControls(): bool
    {
        return match (true) {
            $this->mode === FormMode::View => false,
            $this->form->type === FormType::Advanced => false,
            default => true,
        };
    }

    public function rules(): array
    {
        return $this->form->validation_rules;
    }

    public function messages(): array
    {
        return $this->form->validation_messages;
    }

    public function submit(): void
    {
        if ($this->mode === FormMode::Create) {
            $this->validate();

            if ($this->form->options?->collectResponses) {
                $this->submission = CreateFormSubmission::run($this->form, $this->owner);

                $this->submission = SyncFormSubmissionResponses::run($this->submission, $this->values);
            }

            if ($this->form->options?->emailResponses) {
                if (filled($this->form->options?->emailRecipients)) {
                    $emailValues = $this->transformValuesForEmail();

                    Mail::to($this->form->options?->getEmailRecipients() ?? [])
                        ->queue(new SendNewFormSubmission(
                            user: $this->owner,
                            values: $emailValues,
                            form: $this->form->name,
                        ));
                }
            }

            $this->setBlankValuesForCreate();

            if ($this->admin) {
                redirect()->route('admin.form-submissions.index')->notify('Form submitted');
            }
        }
    }

    public function update(): void
    {
        if ($this->mode === FormMode::Edit) {
            $this->validate();

            if ($this->form->options?->collectResponses) {
                $this->submission = UpdateFormSubmission::run($this->submission, $this->values);
            }

            if ($this->form->options?->emailResponses) {
                if (filled($this->form->options?->emailRecipients)) {
                    $emailValues = $this->transformValuesForEmail();

                    Mail::to($this->form->options?->getEmailRecipients() ?? [])
                        ->queue(new SendUpdatedFormSubmission(
                            user: $this->owner,
                            values: $emailValues,
                            form: $this->form->name,
                        ));
                }
            }

            Notification::make()->success()
                ->title('Form submission updated')
                ->send();
        } else {
            Notification::make()->danger()
                ->title('No form submission found')
                ->body('There is no form submission and the update failed.')
                ->send();
        }
    }

    public function mount(): void
    {
        if ($this->mode === FormMode::Create) {
            $this->setBlankValuesForCreate();
        }

        if ($this->mode === FormMode::Edit || $this->mode === FormMode::View) {
            $this->setValuesFromSubmission();
        }
    }

    public function render(): View
    {
        return view('pages.forms.livewire.dynamic-form', [
            'fields' => $this->fields,
            'mode' => $this->mode,
            'showsFormControls' => $this->showsFormControls,
        ]);
    }

    protected function setBlankValuesForCreate(): void
    {
        $this->values = collect($this->form->published_fields['content'] ?? [])
            ->flatMap(fn ($item) => [data_get($item, 'attrs.values.uid') => ''])
            ->all();
    }

    protected function setValuesFromSubmission(): void
    {
        if (blank($this->submission)) {
            $this->values = [];
        } else {
            $this->values = $this->submission->responses
                ->flatMap(fn (FormSubmissionResponse $response) => [$response->field_uid => $response->value])
                ->all();
        }
    }

    protected function transformValuesForEmail(): array
    {
        $emailValues = [];

        foreach ($this->form->published_fields['content'] as $field) {
            $emailValues[data_get($field, 'attrs.values.label')] = $this->values[data_get($field, 'attrs.values.uid')];
        }

        return $emailValues;
    }
}
