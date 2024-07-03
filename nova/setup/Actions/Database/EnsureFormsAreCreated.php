<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Database;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\Form;
use Nova\Setup\Actions\Database\Schema\DynamicFormSchema;

class EnsureFormsAreCreated
{
    use AsAction;

    public function handle(): void
    {
        if ($this->present()) {
            return;
        }

        Form::unguarded(function () {
            Form::create([
                'name' => 'Character bio',
                'key' => 'character',
                'type' => FormType::Advanced,
                'is_locked' => true,
                'fields' => [
                    DynamicFormSchema::tipTapSchema([
                        DynamicFormSchema::heading(2, 'General information'),
                        DynamicFormSchema::dropdown(label: 'Gender', name: 'gender', options: [
                            ['key' => 'male', 'value' => 'Male'],
                            ['key' => 'female', 'value' => 'Female'],
                            ['key' => 'other', 'value' => 'Other'],
                        ]),
                        DynamicFormSchema::shortText(label: 'Species', name: 'species'),
                        DynamicFormSchema::number(label: 'Age', name: 'age'),
                    ]),
                ],
                'published_fields' => [
                    DynamicFormSchema::heading(2, 'General information'),
                    DynamicFormSchema::dropdown(label: 'Gender', name: 'gender', options: [
                        ['key' => 'male', 'value' => 'Male'],
                        ['key' => 'female', 'value' => 'Female'],
                        ['key' => 'other', 'value' => 'Other'],
                    ]),
                    DynamicFormSchema::shortText(label: 'Species', name: 'species'),
                    DynamicFormSchema::number(label: 'Age', name: 'age'),
                ],
            ]);

            Form::create([
                'name' => 'User bio',
                'key' => 'user',
                'type' => FormType::Advanced,
                'is_locked' => true,
                'fields' => [],
                'published_fields' => [],
            ]);

            Form::create([
                'name' => 'Application info',
                'key' => 'application',
                'type' => FormType::Advanced,
                'is_locked' => true,
                'fields' => [],
                'published_fields' => [],
            ]);
        });
    }

    public function present(): bool
    {
        return Form::whereIn('key', ['character', 'user', 'application'])->count() === 3;
    }
}
