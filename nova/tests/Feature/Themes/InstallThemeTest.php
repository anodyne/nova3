<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Exceptions\MissingQuickInstallFileException;
use Nova\Themes\Models\Theme;
beforeEach(function () {
    $this->disk = Storage::fake('themes');

    $this->theme = Theme::factory()->make([
        'name' => 'Foo',
        'location' => 'foo',
    ]);
});
test('authorized user can install theme', function () {
    $this->signInWithPermission('theme.create');

    $this->disk->makeDirectory('foo');
    $this->disk->put('foo/theme.json', json_encode($this->theme->toArray()));

    $this->followingRedirects();

    $response = $this->post(route('themes.install'), [
        'theme' => $this->theme->location,
    ]);
    $response->assertSuccessful();

    $this->assertDatabaseHas(
        'themes',
        $this->theme->only('name', 'location')
    );
});
test('theme cannot be installed without quick install file', function () {
    $this->signInWithPermission('theme.create');

    $this->disk->makeDirectory('bar');

    $this->withoutExceptionHandling();
    $this->expectException(MissingQuickInstallFileException::class);

    $this->post(route('themes.install'), ['theme' => 'bar']);

    $this->assertDatabaseMissing('themes', [
        'location' => 'bar',
    ]);
});
test('unauthorized user cannot install theme', function () {
    $this->signIn();

    $response = $this->post(route('themes.install'), [
        'theme' => $this->theme->location,
    ]);
    $response->assertForbidden();
});
test('unauthenticated user cannot install theme', function () {
    $response = $this->postJson(route('themes.install'), [
        'theme' => $this->theme->location,
    ]);
    $response->assertUnauthorized();
});
