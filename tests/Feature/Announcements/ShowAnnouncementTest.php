<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Users\Models\User;

use function Pest\Laravel\get;

uses()->group('announcements');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'announcement.view');

        $this->announcement = Announcement::factory()->published()->create();
    });

    test('can view an announcement', function () {
        get(route('admin.announcements.show', $this->announcement))
            ->assertSuccessful()
            ->assertSee($this->announcement->title);
    });

    test('viewing an announcement marks it as read', function () {
        $user = Auth::user();

        AnnouncementNotification::create([
            'announcement_id' => $this->announcement->id,
            'user_id' => $user->id,
            'is_seen' => false,
        ]);

        expect($this->announcement->unreadFor($user))->toBeTrue();

        get(route('admin.announcements.show', $this->announcement));

        $notification = AnnouncementNotification::query()
            ->announcement($this->announcement->id)
            ->user($user->id)
            ->first();

        expect($notification->is_seen)->toBeTrue();
    });

    test('viewing an announcement that is already read does not error', function () {
        $user = Auth::user();

        AnnouncementNotification::create([
            'announcement_id' => $this->announcement->id,
            'user_id' => $user->id,
            'is_seen' => true,
        ]);

        get(route('admin.announcements.show', $this->announcement))
            ->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();

        $this->announcement = Announcement::factory()->published()->create();
    });

    test('cannot view an announcement', function () {
        get(route('admin.announcements.show', $this->announcement))
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    beforeEach(function () {
        User::factory()->create();

        $this->announcement = Announcement::factory()->published()->create();
    });

    test('cannot view an announcement', function () {
        get(route('admin.announcements.show', $this->announcement))
            ->assertRedirectToRoute('login');
    });
});
