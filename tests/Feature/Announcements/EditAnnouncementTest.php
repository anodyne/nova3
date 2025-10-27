<?php

declare(strict_types=1);

// A moderated user updating an announcement has the announcement status set to pending

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Nova\Announcements\Events\AnnouncementUpdated;
use Nova\Announcements\Models\Announcement;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('announcements');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'announcement.update');

        $this->announcement = Announcement::factory()->published()->create();
    });

    test('can view the edit announcement page', function () {
        get(route('admin.announcements.edit', $this->announcement))->assertSuccessful();
    });

    test('can update a announcement', function () {
        Event::fake();

        $data = Announcement::factory()->draft()->make();

        from(route('admin.announcements.edit', $this->announcement))
            ->followingRedirects()
            ->put(route('admin.announcements.update', $this->announcement), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Announcement::class, $data->only('title', 'category', 'status'));

        Event::assertDispatched(AnnouncementUpdated::class);
    });

    test('can publish a draft announcement', function () {
        Event::fake();

        $announcement = Announcement::factory()->draft()->create();

        $data = Announcement::factory()->published()->make();

        from(route('admin.announcements.edit', $announcement))
            ->followingRedirects()
            ->put(route('admin.announcements.update', $announcement), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Announcement::class, [
            'id' => $announcement->id,
            'status' => 'published',
        ]);
    });
});

describe('moderated user', function () {
    beforeEach(function () {
        signIn(permissions: 'announcement.update');

        /** @var \Nova\Users\Models\User $user */
        $user = Auth::user();

        $user->update([
            'moderations' => $user->moderations->append(announcements: true),
        ]);
    });

    test('can update a draft announcement', function () {
        Event::fake();

        $announcement = Announcement::factory()->draft()->create();

        $data = Announcement::factory()->draft()->make();

        from(route('admin.announcements.edit', $announcement))
            ->followingRedirects()
            ->put(route('admin.announcements.update', $announcement), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Announcement::class, [
            'id' => $announcement->id,
            'status' => 'draft',
        ]);
    });

    test('cannot publish a draft announcement', function () {
        Event::fake();

        $announcement = Announcement::factory()->draft()->create();

        $data = Announcement::factory()->published()->make();

        from(route('admin.announcements.edit', $announcement))
            ->followingRedirects()
            ->put(route('admin.announcements.update', $announcement), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Announcement::class, [
            'id' => $announcement->id,
            'status' => 'pending',
        ]);
    });

    test('cannot update a published announcement', function () {
        Event::fake();

        $announcement = Announcement::factory()->published()->create();

        $data = Announcement::factory()->published()->make();

        from(route('admin.announcements.edit', $announcement))
            ->followingRedirects()
            ->put(route('admin.announcements.update', $announcement), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Announcement::class, [
            'id' => $announcement->id,
            'status' => 'pending',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();

        $this->announcement = Announcement::factory()->published()->create();
    });

    test('cannot view the edit announcement page', function () {
        get(route('admin.announcements.edit', $this->announcement))->assertForbidden();
    });

    test('cannot update an announcement', function () {
        put(route('admin.announcements.update', $this->announcement), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    beforeEach(function () {
        User::factory()->create();

        $this->announcement = Announcement::factory()->published()->create();
    });

    test('cannot view the edit announcement page', function () {
        get(route('admin.announcements.edit', $this->announcement))
            ->assertRedirectToRoute('login');
    });

    test('cannot update an announcement', function () {
        put(route('admin.announcements.update', $this->announcement), [])
            ->assertRedirectToRoute('login');
    });
});
