<?php

use Nova\Themes\Models\Theme;
use Illuminate\Support\Facades\Storage;

uses()->group('unit', 'themes');

beforeEach(function () {
    Storage::fake('themes');
});

it('can get a list of pending themes', function () {
    $disk = Storage::disk('themes');

    $disk->makeDirectory('foo');
    $disk->put('foo/theme.json', json_encode(factory(Theme::class)->make()));

    $themes = Theme::get();

    $this->assertCount(3, $themes->withPending());
});

it('collects themes with a quick install file to be installed', function () {
    $disk = Storage::disk('themes');

    $disk->makeDirectory('bar');

    $disk->makeDirectory('foo');
    $disk->put('foo/theme.json', json_encode(factory(Theme::class)->make()));

    $themes = Theme::get();

    $this->assertCount(3, $themes->withPending());
});
