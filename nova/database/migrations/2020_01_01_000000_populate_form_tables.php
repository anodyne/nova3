<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Nova\Forms\Models\Block;
use Nova\Forms\Models\Form;

class PopulateFormTables extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        $this->populateFormBlocks();

        Form::unguard();

        $this->buildCharacterForm();

        $this->buildUserForm();

        $this->buildApplicationForm();

        Form::reguard();

        activity()->enableLogging();
    }

    public function down()
    {
        Schema::dropIfExists('forms_data');
        Schema::dropIfExists('forms_blockables');
        Schema::dropIfExists('forms_blocks');
        Schema::dropIfExists('forms');
    }

    protected function populateFormBlocks()
    {
        collect([
            ['name' => 'Tabs', 'key' => 'tabs', 'category' => 'container', 'type' => 'Nova\\Forms\\Models\\Blocks\\Containers\\Tabs'],
            ['name' => 'Tab item', 'key' => 'tab-item', 'category' => 'container', 'type' => 'Nova\\Forms\\Models\\Blocks\\Containers\\TabItem'],
            ['name' => 'Section', 'key' => 'section', 'category' => 'container', 'type' => 'Nova\\Forms\\Models\\Blocks\\Containers\\Section'],

            ['name' => 'Heading 1', 'key' => 'heading-1', 'category' => 'content', 'type' => 'Nova\\Forms\\Models\\Blocks\\Content\\Heading1'],
            ['name' => 'Heading 2', 'key' => 'heading-2', 'category' => 'content', 'type' => 'Nova\\Forms\\Models\\Blocks\\Content\\Heading2'],
            ['name' => 'Text', 'key' => 'text', 'category' => 'content', 'type' => 'Nova\\Forms\\Models\\Blocks\\Content\\Text'],
            ['name' => 'Image', 'key' => 'image', 'category' => 'content', 'type' => 'Nova\\Forms\\Models\\Blocks\\Content\\Image'],

            ['name' => 'Short text', 'key' => 'short-text', 'category' => 'input', 'type' => 'Nova\\Forms\\Models\\Blocks\\Input\\ShortText'],
            ['name' => 'Long text', 'key' => 'long-text', 'category' => 'input', 'type' => 'Nova\\Forms\\Models\\Blocks\\Input\\LongText'],
            ['name' => 'Email', 'key' => 'email', 'category' => 'input', 'type' => 'Nova\\Forms\\Models\\Blocks\\Input\\Email'],
            ['name' => 'Number', 'key' => 'number', 'category' => 'input', 'type' => 'Nova\\Forms\\Models\\Blocks\\Input\\Number'],
            ['name' => 'URL', 'key' => 'url', 'category' => 'input', 'type' => 'Nova\\Forms\\Models\\Blocks\\Input\\Url'],
            ['name' => 'Hidden', 'key' => 'hidden', 'category' => 'input', 'type' => 'Nova\\Forms\\Models\\Blocks\\Input\\Hidden'],
            ['name' => 'Select one', 'key' => 'select-one', 'category' => 'input', 'type' => 'Nova\\Forms\\Models\\Blocks\\Input\\SelectOne'],
            ['name' => 'Select multiple', 'key' => 'select-multiple', 'category' => 'input', 'type' => 'Nova\\Forms\\Models\\Blocks\\Input\\SelectMultiple'],
        ])->each(fn ($block) => Block::create($block));
    }

    protected function buildCharacterForm()
    {
        $form = Form::create([
            'name' => 'Character form',
            'key' => 'character',
            'locked' => true,
        ]);

        $form->blocks()->attach([
            1 => ['sort' => 1],
            2 => ['sort' => 2, 'parent_id' => 1],
            3 => ['sort' => 1, 'parent_id' => 2],
        ]);
    }

    protected function buildUserForm()
    {
        $form = Form::create([
            'name' => 'User form',
            'key' => 'user',
            'locked' => true,
        ]);

        $form->blocks()->attach([
            1 => ['sort' => 1],
            2 => ['sort' => 2, 'parent_id' => 5],
            3 => ['sort' => 1, 'parent_id' => 6],
        ]);
    }

    protected function buildApplicationForm()
    {
        $form = Form::create([
            'name' => 'Application form',
            'key' => 'application',
            'locked' => true,
        ]);

        $form->blocks()->attach([
            1 => ['sort' => 1],
            2 => ['sort' => 2, 'parent_id' => 7],
            3 => ['sort' => 1, 'parent_id' => 8],
        ]);
    }
}
