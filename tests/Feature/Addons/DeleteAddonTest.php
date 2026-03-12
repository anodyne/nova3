<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Addons\Events\AddonDeleted;
use Nova\Addons\Livewire\AddonsList;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Filament\Actions\DeleteAction;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('addons');

beforeEach(function () {
    Storage::fake('addons');

    $this->addon = Addon::factory()->genre()->active()->create([
        'location' => 'TestGenre',
    ]);

    signIn(permissions: 'addon.delete');
});

test('an authorized user can delete an add-on', function () {
    Storage::fake('ranks');

    Event::fake();

    livewire(AddonsList::class)
        ->callAction(TestAction::make(DeleteAction::class)->table($this->addon))
        ->assertCanNotSeeTableRecords([$this->addon])
        ->assertNotified();

    assertDatabaseMissing(Addon::class, [
        'id' => $this->addon->id,
    ]);

    Event::assertDispatched(AddonDeleted::class);
});
