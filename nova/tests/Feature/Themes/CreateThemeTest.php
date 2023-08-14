<?php

declare(strict_types=1);
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Events\ThemeCreated;
use Nova\Themes\Models\Theme;
use Nova\Themes\Requests\CreateThemeRequest;
beforeEach(function () {
    $this->disk = Storage::fake('themes');

    $this->theme = Theme::factory()->create();
});
test('authorized user can view the create theme page', function () {
    $this->signInWithPermission('theme.create');

    $response = $this->get(route('themes.index'));
    $response->assertSuccessful();
});
test('authorized user can create theme', function () {
    $this->signInWithPermission('theme.create');

    $this->followingRedirects();

    $response = $this->post(
        route('themes.store'),
        $theme = Theme::factory()->make()->toArray()
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('themes', Arr::only($theme, [
        'name',
        'location',
    ]));

    $this->assertRouteUsesFormRequest(
        'themes.store',
        CreateThemeRequest::class
    );
});
test('event is dispatched when theme is created', function () {
    Event::fake();

    $this->signInWithPermission('theme.create');

    $this->post(route('themes.store'), Theme::factory()->make()->toArray());

    Event::assertDispatched(ThemeCreated::class);
});
test('unauthorized user cannot view the create theme page', function () {
    $this->signIn();

    $response = $this->get(route('themes.create'));
    $response->assertForbidden();
});
test('unauthorized user cannot create theme', function () {
    $this->signIn();

    $response = $this->post(
        route('themes.store'),
        Theme::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the create theme page', function () {
    $response = $this->getJson(route('themes.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create theme', function () {
    $response = $this->postJson(
        route('themes.store'),
        Theme::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
