<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Storage;
beforeEach(function () {
    $this->disk = Storage::fake('themes');

    $this->withoutExceptionHandling();
    $this->markTestSkipped();
});
it('can scaffold a theme directory', function () {
    $this->artisan('nova:make-theme', [
        'name' => 'Foo',
    ]);

    $files = $this->disk->allFiles('foo');

    expect($this->disk->directories())->toHaveCount(1);
    expect($files)->toContain('foo/theme.json');
    expect($files)->toContain('foo/Theme.php');
    expect($files)->toContain('foo/design/custom.css');
});
it('can scaffold a theme directory at a custom location', function () {
    $this->artisan('nova:make-theme', [
        'name' => 'Foo',
        '--location' => 'bar',
    ]);

    $directories = $this->disk->directories();

    expect($directories)->toContain('bar');
    expect($directories)->not->toContain('foo');
});
it('can scaffold a theme directory with variant stylesheets', function () {
    $this->artisan('nova:make-theme', [
        'name' => 'Foo',
        '--variants' => ['blue', 'red'],
    ]);

    $files = $this->disk->allFiles('foo');

    expect($files)->toContain('foo/design/variants/blue.css');
    expect($files)->toContain('foo/design/variants/red.css');
});
it('strips unnecessary whitespace from variant filenames', function () {
    $this->artisan('nova:make-theme', [
        'name' => 'Foo',
        '--variants' => ['blue', ' red', 'green ', ' purple '],
    ]);

    $files = $this->disk->allFiles('foo');

    expect($files)->toContain('foo/design/variants/blue.css');
    expect($files)->toContain('foo/design/variants/red.css');
    expect($files)->toContain('foo/design/variants/green.css');
    expect($files)->toContain('foo/design/variants/purple.css');
});
