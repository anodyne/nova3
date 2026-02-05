<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Themes\Events\ThemeUpdated;
use Nova\Themes\Livewire\ThemeSettings;
use Nova\Themes\Models\Theme;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Livewire\livewire;

uses()->group('themes');

beforeEach(function () {
    $this->theme = Theme::factory()->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'theme.update'));

    test('can view the edit theme page', function () {
        get(route('admin.themes.edit', $this->theme))->assertSuccessful();
    });

    test('can update a theme', function () {
        Event::fake();

        $data = themePayload([
            'name' => 'Updated Theme',
            'location' => 'UpdatedTheme',
            'version' => '2.0',
            'preview' => 'updated.png',
            'credits' => 'Updated credits',
            'status' => 'true',
        ]);

        from(route('admin.themes.edit', $this->theme))
            ->followingRedirects()
            ->put(route('admin.themes.update', $this->theme), $data)
            ->assertSuccessful();

        assertDatabaseHas(Theme::class, [
            'id' => $this->theme->id,
            'name' => 'Updated Theme',
            'location' => 'UpdatedTheme',
            'version' => '2.0',
            'preview' => 'updated.png',
            'credits' => 'Updated credits',
            'status' => 'active',
        ]);

        Event::assertDispatched(ThemeUpdated::class);
    });

    test('can update a theme status from inactive to active', function () {
        $theme = Theme::factory()->inactive()->create();

        $data = themePayload([
            'status' => 'true',
        ]);

        from(route('admin.themes.edit', $theme))
            ->followingRedirects()
            ->put(route('admin.themes.update', $theme), $data)
            ->assertSuccessful();

        assertDatabaseHas(Theme::class, [
            'id' => $theme->id,
            'status' => 'active',
        ]);
    });

    test('can update a theme status from active to inactive', function () {
        $theme = Theme::factory()->create();

        $data = themePayload([
            'status' => 'false',
        ]);

        from(route('admin.themes.edit', $theme))
            ->followingRedirects()
            ->put(route('admin.themes.update', $theme), $data)
            ->assertSuccessful();

        assertDatabaseHas(Theme::class, [
            'id' => $theme->id,
            'status' => 'inactive',
        ]);
    });

    test('does not overwrite theme settings when updating details', function () {
        $theme = Theme::factory()->create([
            'settings' => [
                'fonts' => [
                    'headerProvider' => 'local',
                    'headerFamily' => 'Inter',
                    'bodyProvider' => 'local',
                    'bodyFamily' => 'Inter',
                    'monoProvider' => 'local',
                    'monoFamily' => 'Monaspace Neon',
                ],
                'settings' => [
                    'accentColor' => '#123456',
                    'textAccentColor' => '#ffffff',
                ],
            ],
        ]);

        $data = themePayload([
            'name' => 'Retitled Theme',
            'location' => 'RetitledTheme',
            'version' => '2.1',
            'status' => 'true',
        ]);

        from(route('admin.themes.edit', $theme))
            ->followingRedirects()
            ->put(route('admin.themes.update', $theme), $data)
            ->assertSuccessful();

        $theme->refresh();

        expect($theme->settings->settings['accentColor'])->toBe('#123456');
        expect($theme->settings->settings['textAccentColor'])->toBe('#ffffff');
    });

    test('inputs are validated', function () {
        from(route('admin.themes.edit', $this->theme))
            ->put(route('admin.themes.update', $this->theme), [])
            ->assertSessionHasErrors(['name', 'location']);
    });
});

describe('theme settings', function () {
    beforeEach(function () {
        signIn(permissions: 'theme.update');

        $this->theme = Theme::query()->where('location', 'Pulsar')->first();
    });

    test('can load the theme settings form', function () {
        livewire(ThemeSettings::class, ['theme' => $this->theme->location])
            ->assertSet('theme.location', $this->theme->location);
    });

    test('can update theme settings', function () {
        livewire(ThemeSettings::class, ['theme' => $this->theme->location])
            ->set('data', [
                'accentColor' => '#111111',
                'textAccentColor' => '#222222',
            ])
            ->call('save')
            ->assertHasNoErrors();

        $this->theme->refresh();

        expect($this->theme->settings->settings['accentColor'])->toBe('#111111');
        expect($this->theme->settings->settings['textAccentColor'])->toBe('#222222');
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the edit theme page', function () {
        get(route('admin.themes.edit', $this->theme))->assertForbidden();
    });

    test('cannot update a theme', function () {
        put(route('admin.themes.update', $this->theme), themePayload())
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit theme page', function () {
        get(route('admin.themes.edit', $this->theme))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a theme', function () {
        put(route('admin.themes.update', $this->theme), [])
            ->assertRedirectToRoute('login');
    });
});
