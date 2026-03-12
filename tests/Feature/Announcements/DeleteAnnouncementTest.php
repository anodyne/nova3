<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Nova\Announcements\Events\AnnouncementDeleted;
use Nova\Announcements\Livewire\AnnouncementsList;
use Nova\Announcements\Models\Announcement;
use Nova\Foundation\Filament\Actions\DeleteAction;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('announcements');

beforeEach(function () {
    signIn(permissions: 'announcement.delete');

    $this->announcements = Announcement::factory()->published()->count(10)->create();
});

test('an authorized user can delete an announcement', function () {
    Event::fake();

    livewire(AnnouncementsList::class)
        ->callAction(TestAction::make(DeleteAction::class)->table($this->announcements->first()))
        ->assertCanNotSeeTableRecords([$this->announcements->first()])
        ->assertNotified();

    assertDatabaseMissing(Announcement::class, [
        'id' => $this->announcements->first()->id,
    ]);

    Event::assertDispatched(AnnouncementDeleted::class);
});
