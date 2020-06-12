<?php

use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\UpdateTheme;
use Nova\Themes\Events\ThemeUpdated;
use Illuminate\Support\Facades\Event;
use Nova\Themes\DataTransferObjects\ThemeData;

uses()->group('feature', 'themes');

beforeEach(function () {
    $this->theme = factory(Theme::class)->create();
});

test('authorized user can view the edit theme page', function () {
    $this->signInWithPermission('theme.update');

    $response = $this->get(route('themes.edit', $this->theme));
    $response->assertSuccessful();
});

test('authorized user can update a theme', function () {
    $this->signInWithPermission('theme.update');

    $this->followingRedirects()
        ->from(route('themes.edit', $this->theme))
        ->put(route('themes.update', $this->theme), [
            'name' => 'New Name',
            'active' => true,
            'location' => $this->theme->location,
            'layout_auth' => $this->theme->layout_auth,
            'layout_admin' => $this->theme->layout_admin,
            'layout_public' => $this->theme->layout_public,
        ])
        ->assertSuccessful();

    $this->assertDatabaseHas('themes', [
        'id' => $this->theme->id,
        'name' => 'New Name',
    ]);
});

test('unauthorized user cannot view the edit theme page', function () {
    $this->signIn();

    $response = $this->get(route('themes.edit', $this->theme));
    $response->assertForbidden();
});

test('unauthorized user cannot update a theme', function () {
    $this->signIn();

    $response = $this->putJson(route('themes.update', $this->theme), [
        'name' => 'New Name',
        'active' => true,
        'location' => $this->theme->location,
    ]);
    $response->assertForbidden();
});

test('guest cannot view the edit theme page', function () {
    $response = $this->get(route('themes.edit', $this->theme));
    $response->assertRedirect(route('login'));
});

test('guest cannot update a theme', function () {
    $response = $this->put(route('themes.update', $this->theme), []);
    $response->assertRedirect(route('login'));
});

test('an event is dispatched when a theme is updated', function () {
    Event::fake();

    $data = factory(Theme::class)->make()->toArray();

    $theme = app(UpdateTheme::class)->execute($this->theme, new ThemeData($data));

    Event::assertDispatched(ThemeUpdated::class, function ($event) use ($theme) {
        return $event->theme->is($theme);
    });
});
