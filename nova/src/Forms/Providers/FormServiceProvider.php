<?php

declare(strict_types=1);

namespace Nova\Forms\Providers;

use Nova\DomainServiceProvider;
use Nova\Forms\Livewire\DynamicForm;
use Nova\Forms\Livewire\FormDesigner;
use Nova\Forms\Livewire\FormsList;
use Nova\Forms\Livewire\FormSubmissionsList;
use Nova\Forms\Models\Form;
use Nova\Forms\Spotlight;

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
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            Spotlight\DesignForm::class,
            Spotlight\ViewForm::class,
            Spotlight\ViewForms::class,
        ];
    }
}
