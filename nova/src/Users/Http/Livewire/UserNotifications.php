<?php

namespace Nova\Users\Http\Livewire;

use Livewire\Component;

class UserNotifications extends Component
{
    public $notifications = [];

    public function checkNotifications(): void
    {
        $this->notifications = auth()->user()->notifications->toArray();
    }

    public function clearAllNotifications(): void
    {
        auth()->user()->notifications()->delete();

        $this->checkNotifications();
    }

    public function hasNotifications(): bool
    {
        return auth()->user()->notifications->count() > 0;
    }

    public function hasUnreadNotifications(): bool
    {
        return auth()->user()->unreadNotifications->count() > 0;
    }

    public function markAllNotificationsAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();

        $this->checkNotifications();
    }

    public function mount()
    {
        $this->checkNotifications();
    }

    public function render()
    {
        return view('livewire.users.notifications');
    }
}
