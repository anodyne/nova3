<?php

namespace Nova\Forms\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Forms\Enums\FormSubmissionMode;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Filament\Notifications\Notification;

class DynamicForm extends Component
{
    public Form $form;

    public ?FormSubmission $submission = null;

    public bool $admin = false;

    public array $values = [];

    #[Computed]
    public function fields()
    {
        $fields = $this->form->fields;

        foreach ($fields['content'] as $key => $field) {
            $fields['content'][$key]['attrs']['values']['response'] = 'Foo';
        }

        // dd($fields);

        return $fields;

        // dd('done');

        return $this->form->fields;
    }

    #[Computed]
    public function mode(): FormSubmissionMode
    {
        return filled($this->submission)
            ? FormSubmissionMode::Edit
            : FormSubmissionMode::Create;
    }

    public function submit(): void
    {
        $this->submission = FormSubmission::create([]);

        $this->submission->responses()->createMany([]);

        Notification::make()->success()
            ->title('Form submitted')
            ->send();
    }

    public function update(): void
    {
        if (filled($this->submission)) {
            $this->submission->update([]);

            // Update the pivot records

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

    public function render(): View
    {
        return view('pages.forms.livewire.dynamic-form', [
            'fields' => $this->fields,
            'mode' => $this->mode,
        ]);
    }
}