<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Auth;
use Nova\Announcements\Livewire\AnnouncementsList;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Users\Models\User;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('announcements');

beforeEach(function () {
    User::factory()->create();

    $this->announcements = Announcement::factory()->count(10)->published()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'announcement.view');
    });

    test('can view the list announcements page', function () {
        get(route('admin.announcements.index'))->assertSuccessful();

        livewire(AnnouncementsList::class)
            ->assertCanSeeTableRecords($this->announcements);
    });

    test('can filter announcements by category', function () {
        livewire(AnnouncementsList::class)
            ->assertCanSeeTableRecords($this->announcements)
            ->filterTable('category', 'Crew')
            ->assertCanSeeTableRecords($this->announcements->where('category', 'Crew'))
            ->assertCanNotSeeTableRecords($this->announcements->where('category', '!=', 'Crew'))
            ->filterTable('category', 'Story')
            ->assertCanSeeTableRecords($this->announcements->where('category', 'Story'))
            ->assertCanNotSeeTableRecords($this->announcements->where('category', '!=', 'Story'))
            ->filterTable('category', 'Fleet')
            ->assertCanSeeTableRecords($this->announcements->where('category', 'Fleet'))
            ->assertCanNotSeeTableRecords($this->announcements->where('category', '!=', 'Fleet'));
    });

    test('can filter announcements by unread state', function () {
        $user = Auth::user();

        $readAnnouncements = $this->announcements->take(5);
        foreach ($readAnnouncements as $announcement) {
            AnnouncementNotification::create([
                'announcement_id' => $announcement->id,
                'user_id' => $user->id,
                'is_seen' => true,
            ]);
        }

        $unreadAnnouncements = $this->announcements->skip(5);
        foreach ($unreadAnnouncements as $announcement) {
            AnnouncementNotification::create([
                'announcement_id' => $announcement->id,
                'user_id' => $user->id,
                'is_seen' => false,
            ]);
        }

        livewire(AnnouncementsList::class)
            ->filterTable('is_seen', true)
            ->assertCanSeeTableRecords($unreadAnnouncements)
            ->assertCanNotSeeTableRecords($readAnnouncements);

        livewire(AnnouncementsList::class)
            ->filterTable('is_seen', false)
            ->assertCanSeeTableRecords($readAnnouncements)
            ->assertCanNotSeeTableRecords($unreadAnnouncements);
    });

    test('can search announcements by title', function () {
        $title = $this->announcements->first()->title;

        livewire(AnnouncementsList::class)
            ->searchTable($title)
            ->assertCanSeeTableRecords($this->announcements->where('title', $title))
            ->assertCanNotSeeTableRecords($this->announcements->where('title', '!=', $title));
    });
});

describe('admin user', function () {
    beforeEach(function () {
        signIn(permissions: 'announcement.create');

        $this->publishedAnnouncements = Announcement::factory()->published()->count(5)->create();
        $this->draftAnnouncements = Announcement::factory()->draft()->count(3)->create();
    });

    test('can filter announcements by publish state', function () {
        livewire(AnnouncementsList::class)
            ->filterTable('published_at', true)
            ->assertCanSeeTableRecords($this->publishedAnnouncements)
            ->assertCanNotSeeTableRecords($this->draftAnnouncements);

        livewire(AnnouncementsList::class)
            ->filterTable('published_at', false)
            ->assertCanSeeTableRecords($this->draftAnnouncements)
            ->assertCanNotSeeTableRecords($this->publishedAnnouncements);
    });
});

describe('authorized user with announcement create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'announcement.create');
    });

    test('has the correct permissions', function () {
        livewire(AnnouncementsList::class)
            ->assertActionHidden(TestAction::make(EditAction::class)->table($this->announcements->first()))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($this->announcements->first()))
            ->assertActionHidden(TestAction::make('approve')->table($this->announcements->first()))
            ->assertTableFilterVisible('published_at');
    });
});

describe('authorized user with announcement delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'announcement.delete');
    });

    test('has the correct permissions', function () {
        livewire(AnnouncementsList::class)
            ->assertActionHidden(TestAction::make(EditAction::class)->table($this->announcements->first()))
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($this->announcements->first()))
            ->assertActionHidden(TestAction::make('approve')->table($this->announcements->first()))
            ->assertTableFilterVisible('published_at');
    });
});

describe('authorized user with announcement update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'announcement.update');
    });

    test('has the correct permissions', function () {
        livewire(AnnouncementsList::class)
            ->assertActionVisible(TestAction::make(EditAction::class)->table($this->announcements->first()))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($this->announcements->first()))
            ->assertActionHidden(TestAction::make('approve')->table($this->announcements->first()))
            ->assertTableFilterVisible('published_at');
    });
});

describe('authorized user with announcement view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'announcement.view');
    });

    test('has the correct permissions', function () {
        livewire(AnnouncementsList::class)
            ->assertActionHidden(TestAction::make(EditAction::class)->table($this->announcements->first()))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($this->announcements->first()))
            ->assertActionHidden(TestAction::make('approve')->table($this->announcements->first()))
            ->assertTableFilterHidden('published_at');
    });
});

describe('authorized user with announcement approve permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'announcement.approve');
    });

    test('has the correct permissions', function () {
        $announcement = Announcement::factory()->pending()->create();

        livewire(AnnouncementsList::class)
            ->assertActionHidden(TestAction::make(EditAction::class)->table($announcement))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($announcement))
            ->assertActionVisible(TestAction::make('approve')->table($announcement))
            ->assertTableFilterVisible('published_at');
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage announcements page', function () {
        get(route('admin.announcements.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage announcements page', function () {
        get(route('admin.announcements.index'))
            ->assertRedirectToRoute('login');
    });
});
