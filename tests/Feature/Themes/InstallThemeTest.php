<?php

use Nova\Themes\Models\Theme;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Exceptions\MissingQuickInstallFileException;

uses()->group('feature', 'themes');

beforeEach(function () {
    Storage::fake('themes');

    $this->theme = factory(Theme::class)->make([
        'name' => 'Foo',
        'location' => 'foo',
    ]);
});

test('authorized user can install a theme', function () {
    $this->signInWithPermission('theme.create');

    $disk = Storage::disk('themes');

    $disk->makeDirectory('foo');
    $disk->put('foo/theme.json', json_encode($this->theme->toArray()));

    $response = $this->postJson(route('themes.install'), [
        'theme' => $this->theme->location,
    ]);
    $response->assertSuccessful();
    $response->assertJson($this->theme->toArray());

    $this->assertDatabaseHas('themes', $this->theme->only('name'));
});

test('unauthorized user cannot install a theme')
    ->signIn()
    ->postJson('/themes/install', ['theme' => 'foo'])
    ->assertForbidden();

test('guest cannot install a theme')
    ->postJson('/themes/install', ['theme' => 'foo'])
    ->assertUnauthorized();

test('installable themes are shown', function () {
    $disk = Storage::disk('themes');

    $this->signInWithPermission('theme.create');

    $fooTheme = factory(Theme::class)->create([
        'name' => 'Foo',
        'location' => 'foo',
    ]);

    $barTheme = [
        'name' => 'Bar',
        'location' => 'bar',
    ];

    $disk->makeDirectory('bar');
    $disk->put('bar/theme.json', json_encode($barTheme));

    $disk->makeDirectory('foo');

    $response = $this->get(route('themes.index'));
    $response->assertSuccessful();

    $this->assertTrue($response['themes']->contains('name', 'Bar'));
});

test('theme cannot be installed without a quick install file', function () {
    $this->signInWithPermission('theme.create');

    $disk = Storage::disk('themes');
    $disk->makeDirectory('bar');

    $this->withoutExceptionHandling();

    $this->postJson(route('themes.install'), ['theme' => 'bar']);

    $this->assertDatabaseMissing('themes', [
        'location' => 'bar',
    ]);
})->throws(MissingQuickInstallFileException::class);
