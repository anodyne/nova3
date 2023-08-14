<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Themes\Events\ThemeUpdated;
use Nova\Themes\Models\Theme;
beforeEach(function () {
    $this->theme = Theme::factory()->create();
});
test('authorized user can view the edit theme page', function () {
    $this->signInWithPermission('theme.update');

    $response = $this->get(route('themes.edit', $this->theme));
    $response->assertSuccessful();
});
test('authorized user can update theme', function () {
    $this->signInWithPermission('theme.update');

    $this->followingRedirects();

    $response = $this->put(route('themes.update', $this->theme), [
        'name' => 'New Name',
        'active' => true,
        'location' => $this->theme->location,
        'preview' => $this->theme->preview,
    ]);
    $response->assertSuccessful();

    $this->assertDatabaseHas('themes', [
        'id' => $this->theme->id,
        'name' => 'New Name',
    ]);
});
test('event is dispatched when theme is updated', function () {
    Event::fake();

    $this->signInWithPermission('theme.update');

    $this->put(
        route('themes.update', $this->theme),
        Theme::factory()->make()->toArray()
    );

    Event::assertDispatched(ThemeUpdated::class);
});
test('unauthorized user cannot view the edit theme page', function () {
    $this->signIn();

    $response = $this->get(route('themes.edit', $this->theme));
    $response->assertForbidden();
});
test('unauthorized user cannot update theme', function () {
    $this->signIn();

    $response = $this->putJson(
        route('themes.update', $this->theme),
        Theme::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the edit theme page', function () {
    $response = $this->getJson(route('themes.edit', $this->theme));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot update theme', function () {
    $response = $this->putJson(
        route('themes.update', $this->theme),
        Theme::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
