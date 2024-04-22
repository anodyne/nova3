<?php

declare(strict_types=1);

namespace Nova\Foundation\Controllers\Api;

use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Nova\Foundation\Nova;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

class HeartbeatController
{
    public function __invoke(Request $request)
    {
        $environment = Nova::environment();

        return response()->json([
            'nova_version' => Nova::getVersion(),
            'php_version' => $environment?->php?->version,
            'db_driver' => $environment?->database->driverName(),
            'db_version' => $environment?->database?->version,
            'active_users' => User::active()->count(),
            'active_primary_characters' => Character::active()->primary()->count(),
            'active_secondary_characters' => Character::active()->secondary()->count(),
            'active_support_characters' => Character::active()->support()->count(),
            'total_stories' => Story::count(),
            'total_posts' => Post::published()->count(),
            'total_post_words' => (int) Post::published()->sum('word_count'),
            'last_published_post' => Post::latest('published_at')->first()?->published_at,
        ]);
    }
}
