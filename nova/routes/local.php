<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Nova\Conversations\Controllers\ConversationController;
use Nova\Departments\Models\Department;
use Nova\Forms\Models\Form;
use Nova\Setup\Actions\Database\Schema\DynamicFormSchema;

Route::get('messages', [ConversationController::class, 'index']);

Route::get('manifest-test', function () {
    $active = Department::query()
        ->with([
            'positions' => fn ($query) => $query->whereHas('characters'),
            'positions.characters',
        ])
        ->whereHas('positions', fn ($query) => $query->whereHas('characters', fn ($q) => $q->active()))
        ->get();
    $inactive = Department::query()
        ->with([
            'positions' => fn ($query) => $query->whereHas('characters'),
            'positions.characters',
        ])
        ->whereHas('positions', fn ($query) => $query->whereHas('characters', fn ($q) => $q->inactive()))
        ->get();
    $depts = Department::query()
        ->with([
            'positions' => fn ($query) => $query->active(),
            'positions.characters',
        ])
        ->get();
    // dd($manifest);

    echo '<h1>Active</h1>';
    echo '<ul>';
    foreach ($active as $department) {
        echo '<li>';
        echo $department->name;

        echo '<ul>';
        foreach ($department->positions as $position) {
            echo '<li>';
            echo $position->name;

            echo '<ul>';
            foreach ($position->characters as $character) {
                echo '<li>';
                echo $character->name;
                echo '</li>';
            }
            echo '</ul>';
            echo '</li>';
        }
        echo '</ul>';
        echo '</li>';
    }
    echo '</ul>';

    echo '<h1>Inactive</h1>';
    echo '<ul>';
    foreach ($inactive as $department) {
        echo '<li>';
        echo $department->name;

        echo '<ul>';
        foreach ($department->positions as $position) {
            echo '<li>';
            echo $position->name;

            echo '<ul>';
            foreach ($position->characters as $character) {
                echo '<li>';
                echo $character->name;
                echo '</li>';
            }
            echo '</ul>';
            echo '</li>';
        }
        echo '</ul>';
        echo '</li>';
    }
    echo '</ul>';

    echo '<h1>Positions</h1>';
    echo '<ul>';
    foreach ($depts as $department) {
        echo '<li>';
        echo $department->name;

        echo '<ul>';
        foreach ($department->positions as $position) {
            echo '<li>';
            echo $position->name;
            echo '</li>';
        }
        echo '</ul>';
        echo '</li>';
    }
    echo '</ul>';

    return 'done';
});

Route::get('test', function () {
    // $form = Form::find(4);

    // dd(
    //     $form->published_fields,
    //     $form->validation_rules
    // );

    dd(
        DynamicFormSchema::tipTapSchema([
            DynamicFormSchema::shortText(label: 'Label 1'),
            DynamicFormSchema::longText(label: 'Label 2'),
        ])
    );
});
