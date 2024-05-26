<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\Form;

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
