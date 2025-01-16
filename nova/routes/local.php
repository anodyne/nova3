<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Nova\Addons\Models\Addon;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Department;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Models\SystemInfo;
use Nova\Foundation\Nova;
use Nova\Foundation\Values\LatestVersion;
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

Route::get('error-logs', function () {
    $files = LogViewer::getFiles();

    $file = LogViewer::getFile('c119df65-laravel-2024-12-27.log');

    dd($files, $file->logs()->reverse()->get());
    // dd();
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

Route::get('leaderboard', function () {
    // $leaderboard = User::with('posts')->get();

    // $leaderboard = User::query()
    //     ->has('posts')
    //     ->withSum('posts as author_word_count', 'post_author.word_count')
    //     // ->whereExists('posts')
    //     // ->whereHas('posts', fn ($query) => $query->withSum('posts as author_word_count', 'post_author.word_count'))
    //     ->get();

    $leaderboard = User::query()
        ->whereHas('publishedPosts')
        ->withSum('publishedPosts as author_word_count', 'post_author.word_count')
        ->orderByDesc('author_word_count')
        ->get();

    foreach ($leaderboard as $user) {
        echo $user->name.' - '.Number::format((int) $user->author_word_count)."\r\n\r\n";
    }

    // dd($leaderboard->toArray());

    // dd($leaderboard->participatingUsers->sum('pivot.word_count'));

    return 'Done';
});

Route::get('attention', function () {
    $post = Post::find(50);

    dd($post->participatingUsers()->latest('pivot_updated_at')->first()?->pivot?->toArray());
});

Route::get('participation', function () {
    $startDate = now()->subDays(7)->startOfDay();
    $endDate = now()->endOfDay();

    // $results = DB::table('users')
    //     ->join('status_history', function ($join) {
    //         $join->on('users.id', '=', 'status_history.statusable_id')
    //             ->where('status_history.statusable_type', '=', 'user');
    //     })
    //     ->leftJoin('logins', 'users.id', '=', 'logins.user_id')
    //     ->leftJoin('post_author', 'users.id', '=', 'post_author.user_id')
    //     ->leftJoin('posts', 'post_author.post_id', '=', 'posts.id')
    //     ->where('status_history.status', 'active') // Only consider "active" statuses
    //     ->where(function ($query) use ($startDate, $endDate) {
    //         $query->where('status_history.started_at', '<=', $endDate)
    //             ->where(function ($query) use ($startDate) {
    //                 $query->whereNull('status_history.ended_at')
    //                     ->orWhere('status_history.ended_at', '>=', $startDate);
    //             });
    //     })
    //     ->select(
    //         'users.id',
    //         'users.name',
    //         DB::raw('COUNT(DISTINCT logins.id) as login_count'), // Count of logins for each user
    //         DB::raw('COUNT(DISTINCT CASE WHEN posts.status = "published" THEN posts.id END) as published_post_count'), // Count of published posts for each user
    //         DB::raw('COUNT(DISTINCT CASE WHEN posts.status = "draft" THEN posts.id END) as draft_post_count'), // Count of draft posts for each user
    //         DB::raw('SUM(post_author.word_count) as total_word_count') // Sum of word_count for each user
    //     )
    //     ->groupBy('users.id', 'users.name') // Group by individual users
    //     ->get();

    $results = DB::table('users')
        ->join('status_history', function ($join) {
            $join->on('users.id', '=', 'status_history.statusable_id')
                ->where('status_history.statusable_type', '=', 'user');
        })
        ->leftJoin('logins', 'users.id', '=', 'logins.user_id')
        ->leftJoin('post_author', 'users.id', '=', 'post_author.user_id')
        ->leftJoin('posts', 'post_author.post_id', '=', 'posts.id')
        ->leftJoin('post_types', 'posts.post_type_id', '=', 'post_types.id') // Include post_types for JSON filtering
        ->where(function ($query) use ($startDate, $endDate) {
            $query->where('status_history.started_at', '<=', $endDate)
                ->where(function ($query) use ($startDate) {
                    $query->whereNull('status_history.ended_at')
                        ->orWhere('status_history.ended_at', '>=', $startDate);
                });
        })
        ->select(
            'users.id',
            'users.name',
            DB::raw('COUNT(DISTINCT CASE WHEN logins.created_at BETWEEN "'.$startDate.'" AND "'.$endDate.'" THEN logins.id END) as total_logins'), // Count of logins for each user
            DB::raw('COUNT(DISTINCT CASE
                WHEN posts.status = "published"
                    AND JSON_EXTRACT(post_types.options, "$.includedInPostTracking") = true
                    AND post_author.updated_at BETWEEN "'.$startDate.'" AND "'.$endDate.'"
                    AND posts.published_at BETWEEN "'.$startDate.'" AND "'.$endDate.'"
                THEN posts.id
            END) as total_published_posts'), // Count of published posts for each user
            DB::raw('COUNT(DISTINCT CASE
                WHEN posts.status = "draft"
                    AND JSON_EXTRACT(post_types.options, "$.includedInPostTracking") = true
                    AND post_author.updated_at BETWEEN "'.$startDate.'" AND "'.$endDate.'"
                THEN posts.id
            END) as total_draft_posts'), // Count of draft posts for each user
            DB::raw('SUM(CASE
                WHEN JSON_EXTRACT(post_types.options, "$.includedInPostTracking") = true
                    AND post_author.updated_at BETWEEN "'.$startDate.'" AND "'.$endDate.'"
                THEN post_author.word_count
                ELSE 0
            END) as total_words') // Sum of word_count for each user
        )
        ->groupBy('users.id', 'users.name') // Group by individual users
        ->get();

    // $results = User::query()
    //     ->withCount([
    //         'logins as total_logins' => fn ($query) => $query->whereBetween('created_at', [$start, $end]),
    //     ])
    //     ->activeBetween(start: $start, end: $end)
    //     ->first();

    dd($results->toArray());
});

Route::get('external', function () {
    dd(external_content('discord'));
});

Route::get('version', function () {
    $latestVersion = Http::get(config('services.anodyne.api.latest-version'))->json();

    $url = Str::replaceArray('{id}', ['anodyne/nova3'], config('services.github.api.all-releases'));

    $githubVersion = Http::withHeader('X-GitHub-Api-Version', config('services.github.version'))
        ->get($url)
        ->collect();

    dd($url, $githubVersion);

    $versionAnodyne = LatestVersion::fromAnodyne($latestVersion);
    $versionGithub = LatestVersion::fromGithub($githubVersion);

    dd($latestVersion, $githubVersion, $versionAnodyne, $versionGithub);
});
