<?php

use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\CreateTheme;
use Nova\Themes\Events\ThemeCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\DataTransferObjects\ThemeData;
use Nova\Themes\Http\Requests\CreateThemeRequest;

uses()->group('feature', 'themes');

beforeEach(function () {
    $this->theme = factory(Theme::class)->create();
});

test('an authorized user can view the create theme page', function () {
    $this->signInWithPermission('theme.create');

    $response = $this->get(route('themes.create'));
    $response->assertSuccessful();
});

test('an authorized user can create a theme', function () {
    Storage::fake('themes');

    $this->signInWithPermission('theme.create');

    $theme = factory(Theme::class)->make();

    $response = $this->post(route('themes.store'), $theme->toArray());
    $response->assertRedirect(route('themes.index'));

    $this->assertDatabaseHas('themes', $theme->only('name', 'location'));
});

test('an unauthorized user cannot view the create theme page', function () {
    $this->signIn();

    $response = $this->get(route('themes.create'));
    $response->assertForbidden();
});

test('an unauthorized user cannot create a theme', function () {
    $this->signIn();

    $response = $this->postJson(
        route('themes.store'),
        factory(Theme::class)->make()->toArray()
    );
    $response->assertForbidden();
});

test('an unauthenticated user cannot view the create theme page')
    ->get('/themes/create')
    ->assertRedirect('/login');

test('an unauthenticated user cannot create a theme')
    ->postJson('/themes')
    ->assertUnauthorized();

test('a directory is scaffolded when a theme is created', function () {
    Storage::fake('themes');

    $data = factory(Theme::class)->make()->toArray();

    app(CreateTheme::class)->execute(new ThemeData($data));

    $this->assertCount(1, Storage::disk('themes')->directories());
});

test('an event is dispatched when a theme is created', function () {
    Event::fake();
    Storage::fake('themes');

    $data = factory(Theme::class)->make()->toArray();

    $theme = app(CreateTheme::class)->execute(new ThemeData($data));

    Event::assertDispatched(ThemeCreated::class, function ($event) use ($theme) {
        return $event->theme->is($theme);
    });
});

test('creating a theme uses the correct form request')
    ->assertRouteUsesFormRequest('themes.store', CreateThemeRequest::class);
