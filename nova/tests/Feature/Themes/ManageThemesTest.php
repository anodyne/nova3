<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Models\Theme;
beforeEach(function () {
    $this->disk = Storage::fake('themes');
});
test('authorized user with create permission can view manage themes page', function () {
    $this->signInWithPermission('theme.create');

    $response = $this->get(route('themes.index'));
    $response->assertSuccessful();
});
test('authorized user with update permission can view manage themes page', function () {
    $this->signInWithPermission('theme.update');

    $response = $this->get(route('themes.index'));
    $response->assertSuccessful();
});
test('authorized user with delete permission can view manage themes page', function () {
    $this->signInWithPermission('theme.delete');

    $response = $this->get(route('themes.index'));
    $response->assertSuccessful();
});
test('authorized user with view permission can view manage themes page', function () {
    $this->signInWithPermission('theme.view');

    $response = $this->get(route('themes.index'));
    $response->assertSuccessful();
});
test('installable themes are shown with installed themes', function () {
    $this->signInWithPermission('theme.create');

    Theme::factory()->create([
        'name' => 'Foobar',
        'location' => 'foobar',
    ]);

    $this->disk->makeDirectory('bar');
    $this->disk->put('bar/theme.json', json_encode([
        'name' => 'Bar',
        'location' => 'bar',
    ]));

    $this->disk->makeDirectory('foo');

    $response = $this->get(route('themes.index'));
    $response->assertSuccessful();

    expect($response['themes']->where('name', 'Bar'))->toHaveCount(1);
});
test('themes can be filtered to show only themes to be installed', function () {
    $this->signInWithPermission('theme.create');

    Theme::factory()->create([
        'name' => 'Foobar',
        'location' => 'foobar',
    ]);

    $this->disk->makeDirectory('bar');
    $this->disk->put('bar/theme.json', json_encode([
        'name' => 'Bar',
        'location' => 'bar',
    ]));

    $response = $this->get(route('themes.index', 'pending'));
    $response->assertSuccessful();

    expect($response['themes']->where('name', 'Bar'))->toHaveCount(1);
    expect($response['themes']->where('name', 'Foobar'))->toHaveCount(0);
});
test('unauthorized user cannot view manage themes page', function () {
    $this->signIn();

    $response = $this->get(route('themes.index'));
    $response->assertForbidden();
});
test('unauthenticated user cannot view manage themes page', function () {
    $response = $this->getJson(route('themes.index'));
    $response->assertUnauthorized();
});
