<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Themes\Events\ThemeDeleted;
use Nova\Themes\Livewire\ThemesList;
use Nova\Themes\Models\Theme;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('themes');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'theme.delete'));

    test('can delete a theme', function () {
        Event::fake();

        $theme = Theme::factory()->create([
            'name' => 'Nebula',
            'location' => 'Nebula',
        ]);

        livewire(ThemesList::class)
            ->assertCanSeeTableRecords([$theme])
            ->callAction(TestAction::make(DeleteAction::class)->table($theme))
            ->assertCanNotSeeTableRecords([$theme])
            ->assertNotified();

        assertDatabaseMissing(Theme::class, [
            'id' => $theme->id,
        ]);

        Event::assertDispatched(ThemeDeleted::class);
    });

    test('cannot delete the current theme', function () {
        $currentTheme = Theme::factory()->create([
            'name' => 'Cosmos',
            'location' => 'Cosmos',
        ]);

        updateSettings(function ($settings) use ($currentTheme) {
            $settings->appearance = $settings->appearance->with(theme: $currentTheme->location);

            return $settings;
        });

        livewire(ThemesList::class)
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($currentTheme));
    });

    test('cannot delete the last remaining theme', function () {
        $theme = Theme::query()->firstOrFail();

        Theme::query()->whereKeyNot($theme->id)->delete();

        livewire(ThemesList::class)
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($theme));
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot delete themes', function () {
        get(route('admin.themes.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot delete themes', function () {
        get(route('admin.themes.index'))
            ->assertRedirectToRoute('login');
    });
});
