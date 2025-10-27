<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Nova\Announcements\Events\AnnouncementCreated;
use Nova\Announcements\Models\Announcement;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('announcements');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'announcement.create');
    });

    test('can view the create announcement page', function () {
        get(route('admin.announcements.create'))->assertSuccessful();
    });

    test('can create a draft announcement', function () {
        Event::fake();

        $data = Announcement::factory()->draft()->make();

        from(route('admin.announcements.create'))
            ->followingRedirects()
            ->post(route('admin.announcements.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Announcement::class, [
            'title' => $data->title,
            'status' => 'draft',
        ]);

        Event::assertDispatched(AnnouncementCreated::class);
    });

    test('can create a published announcement', function () {
        Event::fake();

        $data = Announcement::factory()->published()->make();

        from(route('admin.announcements.create'))
            ->followingRedirects()
            ->post(route('admin.announcements.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Announcement::class, [
            'title' => $data->title,
            'status' => 'published',
        ]);

        Event::assertDispatched(AnnouncementCreated::class);
    });
});

describe('moderated user', function () {
    beforeEach(function () {
        signIn(permissions: 'announcement.create');

        /** @var \Nova\Users\Models\User $user */
        $user = Auth::user();

        $user->update([
            'moderations' => $user->moderations->append(announcements: true),
        ]);
    });

    test('can create a draft announcement', function () {
        Event::fake();

        $data = Announcement::factory()->draft()->make();

        from(route('admin.announcements.create'))
            ->followingRedirects()
            ->post(route('admin.announcements.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Announcement::class, [
            'title' => $data->title,
            'status' => 'draft',
        ]);
    });

    test('cannot create a published an announcement', function () {
        Event::fake();

        $data = Announcement::factory()->published()->make();

        from(route('admin.announcements.create'))
            ->followingRedirects()
            ->post(route('admin.announcements.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Announcement::class, [
            'title' => $data->title,
            'status' => 'pending',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create announcement page', function () {
        get(route('admin.announcements.create'))->assertForbidden();
    });

    test('cannot create a announcement', function () {
        post(route('admin.announcements.store'), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create announcement page', function () {
        get(route('admin.announcements.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a announcement', function () {
        post(route('admin.announcements.store'), [])
            ->assertRedirectToRoute('login');
    });
});
