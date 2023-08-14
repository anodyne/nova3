<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Models\Theme;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can get a list of themes to be installed', function () {
    Storage::fake('themes');

    $disk = Storage::disk('themes');

    $disk->makeDirectory('foo');
    $disk->put('foo/theme.json', json_encode(Theme::factory()->make()));

    $themes = Theme::get();

    expect($themes->onlyPending())->toHaveCount(1);
});
it('ignores pending themes without a quick install file', function () {
    Storage::fake('themes');

    $disk = Storage::disk('themes');

    $disk->makeDirectory('bar');

    $disk->makeDirectory('foo');
    $disk->put('foo/theme.json', json_encode(Theme::factory()->make()));

    $themes = Theme::get();

    expect($themes->onlyPending())->toHaveCount(1);
});
