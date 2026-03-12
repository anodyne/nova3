<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Nova\Announcements\Livewire\AnnouncementsList;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Announcements\Notifications\AnnouncementPublished;
use Nova\Users\Models\User;

use function Pest\Laravel\post;
use function Pest\Livewire\livewire;

uses()->group('announcements');

test('publishing an announcement notifies all active users except the author', function () {
    signIn(permissions: 'announcement.create');

    Notification::fake();

    $users = User::factory()->count(5)->active()->create();
    $author = Auth::user();

    $data = Announcement::factory()->published()->make();

    post(route('admin.announcements.store'), $data->toArray());

    $announcement = Announcement::latest()->first();

    foreach ($users as $user) {
        if ($user->id !== $author->id) {
            Notification::assertSentTo($user, AnnouncementPublished::class);
        }
    }

    Notification::assertNotSentTo($author, AnnouncementPublished::class);
});

test('approving a pending announcement notifies all active users except approver', function () {
    signIn(permissions: 'announcement.approve');

    Notification::fake();

    User::factory()->active()->count(3)->create();

    $announcement = Announcement::factory()->pending()->create();

    livewire(AnnouncementsList::class)
        ->callAction(TestAction::make('approve')->table($announcement));

    Notification::assertSentTimes(AnnouncementPublished::class, 3);
});

test('announcement notifications are marked as seen for the author', function () {
    signIn(permissions: 'announcement.create');

    User::factory()->active()->count(2)->create();
    $author = Auth::user();

    $data = Announcement::factory()->published()->make();

    post(route('admin.announcements.store'), $data->toArray());

    $announcement = Announcement::latest()->first();

    $authorNotification = AnnouncementNotification::query()
        ->announcement($announcement->id)
        ->user($author->id)
        ->first();

    expect($authorNotification->is_seen)->toBeTrue();
});

test('publishing announcement creates notification records for all users', function () {
    $users = User::factory()->active()->count(5)->create();
    signIn(permissions: 'announcement.create');

    $data = Announcement::factory()->published()->make();
    post(route('admin.announcements.store'), $data->toArray());

    $announcement = Announcement::latest()->first();

    // Should create notifications for all 5 users + the author = 6 total
    expect(AnnouncementNotification::count())->toBe(6);

    foreach ($users as $user) {
        expect(
            AnnouncementNotification::query()
                ->announcement($announcement->id)
                ->user($user->id)
                ->exists()
        )->toBeTrue();
    }
});

test('draft announcements do not create notification records', function () {
    signIn(permissions: 'announcement.create');

    User::factory()->active()->count(5)->create();

    $data = Announcement::factory()->draft()->make();

    post(route('admin.announcements.store'), $data->toArray());

    expect(AnnouncementNotification::count())->toBe(0);
});

test('pending announcements do not create notification records', function () {
    signIn(permissions: 'announcement.create');

    User::factory()->active()->count(5)->create();
    $user = Auth::user();

    $user->update([
        'moderations' => $user->moderations->append(announcements: true),
    ]);

    $data = Announcement::factory()->published()->make();

    post(route('admin.announcements.store'), $data->toArray());

    $announcement = Announcement::latest()->first();

    expect($announcement->status->value)->toBe('pending');
    expect(AnnouncementNotification::count())->toBe(0);
});

test('only active users receive notifications', function () {
    Notification::fake();

    $activeUsers = User::factory()->active()->count(3)->create();
    $inactiveUsers = User::factory()->inactive()->count(2)->create();

    signIn(permissions: 'announcement.create');

    $data = Announcement::factory()->published()->make();
    post(route('admin.announcements.store'), $data->toArray());

    // Active users should be notified
    foreach ($activeUsers as $user) {
        Notification::assertSentTo($user, AnnouncementPublished::class);
    }

    // Inactive users should NOT be notified
    foreach ($inactiveUsers as $user) {
        Notification::assertNotSentTo($user, AnnouncementPublished::class);
    }
});
