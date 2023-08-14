<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Events\ThemeDeleted;
use Nova\Themes\Models\Theme;
beforeEach(function () {
    $this->disk = Storage::fake('themes');

    $this->theme = Theme::factory()->create();
    $this->secondTheme = Theme::factory()->create();
});
test('authorized user can delete theme', function () {
    $this->signInWithPermission('theme.delete');

    $this->followingRedirects();

    $response = $this->delete(route('themes.destroy', $this->theme));
    $response->assertSuccessful();

    $this->assertDatabaseMissing(
        'themes',
        $this->theme->only('name', 'location')
    );
});
test('the theme directory is not removed when a theme is deleted', function () {
    $this->disk->makeDirectory($this->theme->location);

    $this->signInWithPermission('theme.delete');

    $this->delete(route('themes.destroy', $this->theme));

    expect(in_array(
        $this->theme->location,
        $this->disk->directories()
    ))->toBeTrue();
});
test('when the default theme is deleted another theme is set as the default', function () {
    $this->markTestIncomplete('Default themes not implemented yet');

    $this->signInWithPermission('theme.delete');

    $this->delete(route('themes.destroy', $this->theme));
});
test('event is dispatched when theme is deleted', function () {
    Event::fake();

    $this->signInWithPermission('theme.delete');

    $this->delete(route('themes.destroy', $this->theme));

    Event::assertDispatched(ThemeDeleted::class);
});
test('if there is only one theme it cannot be deleted', function () {
    $this->signInWithPermission('theme.delete');

    Theme::where('id', '!=', $this->theme->id)->delete();

    $response = $this->delete(route('themes.destroy', $this->theme));
    $response->assertForbidden();

    $this->assertDatabaseHas(
        'themes',
        $this->theme->only('name', 'location')
    );
});
test('unauthorized user cannot delete theme', function () {
    $this->signIn();

    $response = $this->delete(route('themes.destroy', $this->theme));
    $response->assertForbidden();
});
test('unauthenticated user cannot delete theme', function () {
    $response = $this->deleteJson(route('themes.destroy', $this->theme));
    $response->assertUnauthorized();
});
