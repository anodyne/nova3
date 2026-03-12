<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Nova\Announcements\Events\AnnouncementPublished;
use Nova\Announcements\Livewire\AnnouncementsList;
use Nova\Announcements\Models\Announcement;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('announcements');

beforeEach(function () {
    signIn(permissions: 'announcement.approve');

    $this->pendingAnnouncement = Announcement::factory()->pending()->create();
});

test('an authorized user can approve a pending announcement', function () {
    Event::fake();

    livewire(AnnouncementsList::class)
        ->callAction(TestAction::make('approve')->table($this->pendingAnnouncement))
        ->assertNotified();

    assertDatabaseHas(Announcement::class, [
        'id' => $this->pendingAnnouncement->id,
        'status' => 'published',
    ]);

    Event::assertDispatched(AnnouncementPublished::class);
});
