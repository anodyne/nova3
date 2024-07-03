<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\Form;
use Nova\Setup\Actions\Database\Schema\DynamicFormSchema;

class PopulateFormTables extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        Form::unguarded(function () {
            Form::create([
                'name' => 'Character form',
                'key' => 'character',
                'type' => FormType::Advanced,
                'is_locked' => true,
                'fields' => [
                    DynamicFormSchema::shortText(label: 'Label 1', description: 'Ut laborum nisi minim ullamco veniam aute.'),
                    DynamicFormSchema::shortText(label: 'Label 2', description: 'Ut laborum nisi minim ullamco veniam aute.'),
                    DynamicFormSchema::shortText(label: 'Label 3', description: 'Ut laborum nisi minim ullamco veniam aute.'),
                ],
            ]);

            Form::create([
                'name' => 'User form',
                'key' => 'user',
                'type' => FormType::Advanced,
                'is_locked' => true,
            ]);

            Form::create([
                'name' => 'Application form',
                'key' => 'application',
                'type' => FormType::Advanced,
                'is_locked' => true,
            ]);
        });

        activity()->enableLogging();
    }

    public function down()
    {
        Form::truncate();
    }
}
