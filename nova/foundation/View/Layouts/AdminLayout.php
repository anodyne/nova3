<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Layouts;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Nova\Announcements\Models\Announcement;
use Nova\Applications\Models\Application;
use Nova\Pages\Models\Page;
use Nova\Stories\Models\Post;

class AdminLayout extends Component
{
    protected ?Page $page;

    protected ?string $subnav;

    public function __construct()
    {
        $this->page = request()->route()?->findPageFromRoute();
        $this->subnav = app('nova.meta')->subnavSection;
    }

    public function draftPostsNeedingAttentionCount(): int
    {
        return once(fn () => Auth::user()->draftPostsNeedingAttention()->count());
    }

    public function pendingApplicationsCount(): int
    {
        return once(fn () => Application::pending()->count());
    }

    public function pendingApprovalsCount(): int
    {
        return once(function (): int {
            /** @var \Nova\Users\Models\User $user */
            $user = Auth::user();

            $count = 0;

            if ($user->can('approveAny', Announcement::class)) {
                $count += Announcement::query()->pending()->count();
            }

            if ($user->can('approveAny', Post::class)) {
                $count += Post::query()->pending()->count();
            }

            return $count;
        });
    }

    public function unreadAnnouncementsCount(): int
    {
        return once(fn () => Auth::user()->unread_announcements_count);
    }

    public function unreadMessagesCount(): int
    {
        return once(fn () => Auth::user()->unread_messages_count);
    }

    public function unreadNotificationsCount(): int
    {
        return once(fn () => Auth::user()->unreadNotifications()->count());
    }

    public function render()
    {
        return view('layouts.admin');
    }
}
