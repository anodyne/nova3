<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Layouts;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Nova\Announcements\Models\Announcement;
use Nova\Applications\Models\Application;
use Nova\Pages\Models\Page;
use Nova\Stories\Models\Post;
use Nova\Users\Models\User;

class AdminLayout extends Component
{
    protected ?Page $page;

    protected ?string $subnav;

    protected User $user;

    public function __construct()
    {
        $this->page = request()->route()?->findPageFromRoute();
        $this->subnav = app('nova.meta')->subnavSection;
        $this->user = Auth::user();
    }

    public function themeDataAttribute(): ?string
    {
        $primaryColor = settings('appearance.colorsPrimary');

        if ($primaryColor !== 'Mono') {
            return null;
        }

        return ' data-theme="mono"';
    }

    public function draftPostsNeedingAttentionCount(): int
    {
        return once(fn () => $this->user->draftPostsNeedingAttention()->count());
    }

    public function pendingApplicationsCount(): int
    {
        return once(fn () => Application::pending()->count());
    }

    public function pendingApprovalsCount(): int
    {
        return once(function (): int {
            $count = 0;

            if ($this->user->can('approveAny', Announcement::class)) {
                $count += Announcement::query()->pending()->count();
            }

            if ($this->user->can('approveAny', Post::class)) {
                $count += Post::query()->pending()->count();
            }

            return $count;
        });
    }

    public function unreadAnnouncementsCount(): int
    {
        return once(fn () => $this->user->unread_announcements_count);
    }

    public function unreadMessagesCount(): int
    {
        return once(fn () => $this->user->unread_messages_count);
    }

    public function unreadNotificationsCount(): int
    {
        return once(fn () => $this->user->unreadNotifications()->count());
    }

    public function render(): View
    {
        return view('layouts.admin');
    }
}
