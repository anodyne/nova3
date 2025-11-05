<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Users\Livewire\BansList;
use Nova\Users\Models\Ban;

use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('bans');

beforeEach(function () {
    $this->bans = Ban::factory()->count(5)->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'ban.delete'));

    test('can delete a ban', function () {
        livewire(BansList::class)
            ->callAction(TestAction::make(DeleteAction::class)->table($this->bans->first()))
            ->assertCanNotSeeTableRecords([$this->bans->first()])
            ->assertNotified();

        assertSoftDeleted(Ban::class, [
            'id' => $this->bans->first()->id,
        ]);
    });

    test('can bulk delete bans', function () {
        livewire(BansList::class)
            ->selectTableRecords($this->bans)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertCanNotSeeTableRecords([$this->bans])
            ->assertNotified();

        foreach ($this->bans as $ban) {
            assertSoftDeleted(Ban::class, [
                'id' => $ban->id,
            ]);
        }
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot delete bans', function () {
        get(route('admin.bans.index'))
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot delete bans', function () {
        get(route('admin.bans.index'))
            ->assertRedirectToRoute('login');
    });
});
