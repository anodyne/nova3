<?php

declare(strict_types=1);

namespace Nova\Forms\Providers;

use Nova\DomainServiceProvider;
use Nova\Forms\Livewire\DynamicForm;
use Nova\Forms\Livewire\FormDesigner;
use Nova\Forms\Livewire\FormsList;
use Nova\Forms\Livewire\FormSubmissionsList;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormField;
use Nova\Forms\Models\FormSubmission;
use Nova\Forms\Models\FormSubmissionResponse;
use Nova\Forms\Spotlight\DesignForm;
use Nova\Forms\Spotlight\ViewForm;
use Nova\Forms\Spotlight\ViewForms;

class FormServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'dynamic-form' => DynamicForm::class,
            'forms-designer' => FormDesigner::class,
            'forms-list' => FormsList::class,
            'forms-submissions-list' => FormSubmissionsList::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'form' => Form::class,
            'form-field' => FormField::class,
            'form-submission' => FormSubmission::class,
            'form-submission-response' => FormSubmissionResponse::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'form_' => Form::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            DesignForm::class,
            ViewForm::class,
            ViewForms::class,
        ];
    }
}
