<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Layouts;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Nova\Applications\Models\Application;
use Nova\Pages\Models\Page;

class AdminLayout extends Component
{
    protected ?Page $page;

    protected ?string $subnav;

    public function __construct()
    {
        $this->page = request()->route()?->findPageFromRoute();
        $this->subnav = app('nova.meta')->subnavSection;
    }

    public function pendingApplicationsCount(): int
    {
        return once(fn () => Application::pending()->count());
    }

    public function unreadAnnouncementsCount(): int
    {
        return once(fn () => Auth::user()->unread_announcements_count);
    }

    public function unreadMessagesCount(): int
    {
        return once(fn () => Auth::user()->unread_messages_count);
    }

    public function render()
    {
        return view('layouts.admin');
    }
}
