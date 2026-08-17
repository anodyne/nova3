<?php

declare(strict_types=1);

namespace Nova\Dashboards\Controllers;

use Nova\Announcements\Models\Announcement;
use Nova\Dashboards\Responses\PendingApprovalResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Models\Post;

class PendingApprovalController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware([
            'auth',
            'permission:announcement.approve|post.approve',
        ]);
    }

    public function __invoke()
    {
        return PendingApprovalResponse::sendWith([
            'announcements' => Announcement::pending()->with(['user'])->select(['id', 'title', 'category', 'user_id'])->get(),
            'posts' => Post::query()->select(['id', 'title', 'story_id', 'post_type_id'])->pending()->get(),
        ]);
    }
}
