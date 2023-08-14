<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Actions\SetupThemeDirectory;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Models\Theme;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->disk = Storage::fake('themes');
});
it('creates the new theme directory', function () {
    SetupThemeDirectory::run(ThemeData::from(
        Theme::factory()->make()->toArray()
    ));

    expect($this->disk->directories())->toHaveCount(1);
});
