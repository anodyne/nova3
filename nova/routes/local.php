<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Nova\Departments\Models\Department;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Models\Discussion;
use Nova\Forms\Models\Form;
use Opcodes\LogViewer\Facades\LogViewer;

Route::get('discussions', function () {
    $discussion = Discussion::find(2);

    $data = DiscussionData::from($discussion);

    dd($data);

    dd('done');
});

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
    $form = Form::find(5);

    dd($form->generatePrefixedId());
});

Route::get('logs', function () {
    $files = LogViewer::getFiles();

    $file = LogViewer::getFile('a2a4c792-laravel-2024-09-17.log');

    dd($files, $file, $file->logs()->get());
});
