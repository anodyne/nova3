<?php

use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\DeleteTheme;
use Nova\Themes\Events\ThemeDeleted;
use Illuminate\Support\Facades\Event;

uses()->group('feature', 'themes');

beforeEach(function () {
    $this->theme = factory(Theme::class)->create();
});

test('authorized user can delete a theme', function () {
    $this->signInWithPermission('theme.delete');

    $response = $this->delete(route('themes.destroy', $this->theme));
    $response->assertRedirect(route('themes.index'));

    $this->assertDatabaseMissing('themes', $this->theme->only('id', 'name'));
});

test('unauthorized user cannot delete a theme', function () {
    $this->signIn();

    $response = $this->deleteJson(route('themes.destroy', $this->theme));
    $response->assertForbidden();
});

test('guest cannot delete a theme', function () {
    $response = $this->deleteJson(route('themes.destroy', $this->theme));
    $response->assertUnauthorized();
});

test('event is dispatched when a theme is deleted', function () {
    Event::fake();

    $theme = app(DeleteTheme::class)->execute($this->theme);

    Event::assertDispatched(ThemeDeleted::class, function ($event) use ($theme) {
        return $event->theme->is($theme);
    });
});
