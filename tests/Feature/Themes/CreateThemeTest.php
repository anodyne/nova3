<?php

use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\CreateTheme;
use Nova\Themes\Events\ThemeCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\DataTransferObjects\ThemeData;

uses()->group('feature', 'themes');

beforeEach(function () {
    $this->theme = factory(Theme::class)->create();
});

test('authorized user can view the create theme page', function () {
    $this->signInWithPermission('theme.create');

    $response = $this->get(route('themes.create'));
    $response->assertSuccessful();
});

test('authorized user can create a theme', function () {
    $this->withoutExceptionHandling();

    Storage::fake('themes');

    $this->signInWithPermission('theme.create');

    $theme = factory(Theme::class)->make();

    $response = $this->post(route('themes.store'), $theme->toArray());
    $response->assertRedirect(route('themes.index'));

    $this->assertDatabaseHas('themes', $theme->only('name', 'location'));
});

test('unauthorized user cannot view the create theme page', function () {
    $this->signIn();

    $response = $this->get(route('themes.create'));
    $response->assertForbidden();
});

test('unauthorized user cannot create a theme', function () {
    $this->signIn();

    $response = $this->postJson(
        route('themes.store'),
        factory(Theme::class)->make()->toArray()
    );
    $response->assertForbidden();
});

test('guest cannot view the create theme page')
    ->get('/themes/create')
    ->assertRedirect('/login');

test('guest cannot create a theme')
    ->postJson('/themes')
    ->assertUnauthorized();

test('theme directory is scaffolded when a theme is created', function () {
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

test('name is required to create a theme', function () {
    Storage::fake('themes');

    $this->signInWithPermission('theme.create');

    $this->from(route('themes.index'))
        ->post(route('themes.store'), [
            'name' => null,
            'location' => 'some-location',
        ])
        ->assertSessionHasErrors('name');
});

test('location is required to create a theme', function () {
    Storage::fake('themes');

    $this->signInWithPermission('theme.create');

    $this->from(route('themes.index'))
        ->post(route('themes.store'), [
            'name' => 'some-name',
            'location' => null,
        ])
        ->assertSessionHasErrors('location');
});
