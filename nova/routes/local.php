<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Nova\Addons\Models\Addon;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Department;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Models\SystemInfo;
use Nova\Foundation\Nova;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;
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

Route::get('logs', function () {
    $files = LogViewer::getFiles();

    $file = LogViewer::getFile('a2a4c792-laravel-2024-09-17.log');

    dd($files, $file, $file->logs()->get());
});

Route::get('telemetry', function () {
    $systemInfo = SystemInfo::first();

    $data = [
        'url' => url('/'),
        'genre' => Addon::active()->genre()->first()?->location ?? 'blank',
        'php_version' => phpversion(),
        'db_driver' => Nova::environment()->database->driver,
        'db_version' => Nova::environment()->database->version,
        'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
        'install_date' => $systemInfo->install_date?->format('Y-m-d h:i:s'),
        'name' => settings('general.gameName'),
        'version' => Nova::filesVersion(),
        'previous_version' => $systemInfo->version,
        'active_users' => User::active()->count(),
        'active_primary_characters' => Character::active()->primary()->count(),
        'active_secondary_characters' => Character::active()->secondary()->count(),
        'active_support_characters' => Character::active()->support()->count(),
        'total_stories' => Story::count(),
        'total_posts' => Post::published()->count(),
        'total_post_words' => (int) Post::published()->sum('word_count'),
        'last_published_post' => Post::latest('published_at')->first()?->published_at?->format('Y-m-d h:i:s'),
    ];

    if (filled($systemInfo->anodyne_game_id)) {
        $data['game_id'] = $systemInfo->anodyne_game_id;
    }

    dd($data);
});
