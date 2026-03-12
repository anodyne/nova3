<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Events\ThemeCreated;
use Nova\Themes\Models\Theme;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('themes');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'theme.create'));

    test('can view the create theme page', function () {
        get(route('admin.themes.create'))->assertSuccessful();
    });

    test('can create a theme', function () {
        Event::fake();
        Storage::fake('themes');

        $data = themePayload([
            'name' => 'Test Theme',
            'location' => 'TestTheme',
        ]);

        from(route('admin.themes.create'))
            ->followingRedirects()
            ->post(route('admin.themes.store'), $data)
            ->assertSuccessful();

        assertDatabaseHas(Theme::class, [
            'name' => 'Test Theme',
            'location' => 'TestTheme',
            'status' => 'active',
        ]);

        Storage::disk('themes')->assertExists('TestTheme');
        Storage::disk('themes')->assertExists('TestTheme/theme.json');
        Storage::disk('themes')->assertExists('TestTheme/Theme.php');
        Storage::disk('themes')->assertExists('TestTheme/design/theme.css');
        Storage::disk('themes')->assertExists('TestTheme/views/components/layouts/theme.blade.php');

        Event::assertDispatched(ThemeCreated::class);
    });

    test('inputs are validated', function () {
        from(route('admin.themes.create'))
            ->post(route('admin.themes.store'), [])
            ->assertSessionHasErrors(['name', 'location']);

        $theme = Theme::factory()->create(['location' => 'ExistingTheme']);

        from(route('admin.themes.create'))
            ->post(route('admin.themes.store'), themePayload([
                'name' => 'Duplicate Theme',
                'location' => $theme->location,
            ]))
            ->assertSessionHasErrors(['location']);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the create theme page', function () {
        get(route('admin.themes.create'))->assertForbidden();
    });

    test('cannot create a theme', function () {
        post(route('admin.themes.store'), themePayload(['location' => 'AnotherTestTheme']))
            ->assertForbidden();

        assertDatabaseMissing(Theme::class, [
            'location' => 'AnotherTestTheme',
        ]);
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create theme page', function () {
        get(route('admin.themes.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a theme', function () {
        post(route('admin.themes.store'), [])
            ->assertRedirectToRoute('login');
    });
});
