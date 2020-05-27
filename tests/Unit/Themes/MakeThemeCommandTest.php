<?php

use Illuminate\Support\Facades\Storage;

uses()->group('unit', 'themes');

beforeEach(function () {
    Storage::fake('themes');
});

it('can scaffold a theme directory', function () {
    $this->artisan('nova:make-theme', [
        'name' => 'Foo',
    ]);

    $disk = Storage::disk('themes');
    $files = $disk->allFiles('foo');

    $this->assertCount(1, $disk->directories());
    $this->assertContains('foo/theme.json', $files);
    $this->assertContains('foo/Theme.php', $files);
    $this->assertContains('foo/design/custom.css', $files);
});

it('can scaffold a theme with a custom location', function () {
    $this->artisan('nova:make-theme', [
        'name' => 'Foo',
        '--location' => 'bar',
    ]);

    $directories = Storage::disk('themes')->directories();

    $this->assertContains('bar', $directories);
    $this->assertNotContains('foo', $directories);
});

it('can scaffold a theme with style variants', function () {
    $this->artisan('nova:make-theme', [
        'name' => 'Foo',
        '--variants' => ['blue', 'red'],
    ]);

    $files = Storage::disk('themes')->allFiles('foo');

    $this->assertContains('foo/design/variants/blue.css', $files);
    $this->assertContains('foo/design/variants/red.css', $files);
});

it('requires a location to scaffold a theme', function () {
    Storage::disk('themes')->makeDirectory('foo');

    $this->artisan('nova:make-theme', [
        'name' => 'Foo',
    ]);
})->throws(RuntimeException::class);
