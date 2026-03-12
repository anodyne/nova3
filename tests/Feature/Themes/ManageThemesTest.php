<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Storage;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Themes\Livewire\ThemeSelector;
use Nova\Themes\Livewire\ThemesList;
use Nova\Themes\Models\Theme;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('themes');

beforeEach(function () {
    $this->themes = Theme::factory()
        ->count(6)
        ->sequence(fn (Sequence $sequence): array => [
            'name' => 'Theme '.($sequence->index + 1),
            'location' => 'theme-'.($sequence->index + 1),
            'status' => $sequence->index % 2 === 0 ? BasicStatus::Active : BasicStatus::Inactive,
        ])
        ->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'theme.create'));

    test('can view the list themes page', function () {
        get(route('admin.themes.index'))->assertSuccessful();

        livewire(ThemesList::class)
            ->assertCanSeeTableRecords($this->themes);
    });

    test('can search themes by name', function () {
        $theme = Theme::factory()->create(['name' => 'Midnight Theme']);

        livewire(ThemesList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->resetTableFilters()
            ->searchTable('Midnight Theme')
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords([$theme]);
    });

    test('can filter themes by status', function () {
        livewire(ThemesList::class)
            ->filterTable('status', BasicStatus::Active->value)
            ->assertCanSeeTableRecords($this->themes->where('status', BasicStatus::Active))
            ->assertCanNotSeeTableRecords($this->themes->where('status', BasicStatus::Inactive))
            ->filterTable('status', BasicStatus::Inactive->value)
            ->assertCanSeeTableRecords($this->themes->where('status', BasicStatus::Inactive))
            ->assertCanNotSeeTableRecords($this->themes->where('status', BasicStatus::Active));
    });
});

describe('authorized user with theme create permissions', function () {
    beforeEach(fn () => signIn(permissions: 'theme.create'));

    test('has the correct permissions', function () {
        $theme = $this->themes->first();

        livewire(ThemesList::class)
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($theme))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($theme))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($theme));
    });

    test('can open the install themes action when installable themes exist', function () {
        $disk = Storage::fake('themes');

        $disk->put('InstallableTheme/theme.json', json_encode([
            'name' => 'Installable Theme',
            'location' => 'InstallableTheme',
            'version' => '1.0',
            'preview' => 'preview.png',
            'repository' => [
                'type' => '',
                'id' => '',
            ],
        ], JSON_THROW_ON_ERROR));

        livewire(ThemesList::class)
            ->assertActionVisible(TestAction::make('install')->table());
    });

    test('install themes action is hidden when none are installable', function () {
        Storage::fake('themes');

        livewire(ThemesList::class)
            ->assertActionHidden(TestAction::make('install')->table());
    });
});

describe('authorized user with theme delete permissions', function () {
    beforeEach(fn () => signIn(permissions: 'theme.delete'));

    test('has the correct permissions', function () {
        $theme = $this->themes->first();

        livewire(ThemesList::class)
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($theme))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($theme))
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($theme));
    });
});

describe('authorized user with theme update permissions', function () {
    beforeEach(fn () => signIn(permissions: 'theme.update'));

    test('has the correct permissions', function () {
        $theme = $this->themes->first();

        livewire(ThemesList::class)
            ->assertActionHidden(TestAction::make(ViewAction::class)->table($theme))
            ->assertActionVisible(TestAction::make(EditAction::class)->table($theme))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($theme));
    });
});

describe('authorized user with theme view permissions', function () {
    beforeEach(fn () => signIn(permissions: 'theme.view'));

    test('has the correct permissions', function () {
        $theme = $this->themes->first();

        livewire(ThemesList::class)
            ->assertActionVisible(TestAction::make(ViewAction::class)->table($theme))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($theme))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($theme));
    });

    test('can view a theme details page', function () {
        $theme = $this->themes->first();

        get(route('admin.themes.show', $theme))
            ->assertSuccessful();
    });
});

describe('theme selector', function () {
    test('loads active themes', function () {
        $activeTheme = Theme::factory()->create([
            'name' => 'Aurora',
            'status' => BasicStatus::Active,
        ]);

        $inactiveTheme = Theme::factory()->inactive()->create([
            'name' => 'Shadow',
        ]);

        livewire(ThemeSelector::class)
            ->assertSee($activeTheme->name)
            ->assertDontSee($inactiveTheme->name);
    });

    test('selects the current theme from settings', function () {
        $theme = Theme::factory()->create([
            'name' => 'Comet',
            'location' => 'Comet',
        ]);

        updateSettings(function ($settings) use ($theme) {
            $settings->appearance = $settings->appearance->with(
                theme: $theme->location
            );

            return $settings;
        });

        livewire(ThemeSelector::class)
            ->assertSet('selected', $theme->location);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the manage themes page', function () {
        get(route('admin.themes.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage themes page', function () {
        get(route('admin.themes.index'))->assertRedirectToRoute('login');
    });
});
