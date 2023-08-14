<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Actions\DeleteTheme;
use Nova\Themes\Models\Theme;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->disk = Storage::fake('themes');
    $this->disk->makeDirectory('slate');
    $this->disk->put('slate/theme.json', json_encode([
        'name' => 'Slate',
        'location' => 'slate',
    ]));

    $this->theme = Theme::factory()->create([
        'name' => 'Slate',
        'location' => 'slate',
    ]);
});
it('deletes a theme', function () {
    $theme = DeleteTheme::run($this->theme);

    expect($theme->exists)->toBeFalse();
});
it('does not remove the theme directory when the theme is deleted', function () {
    DeleteTheme::run($this->theme);

    expect($this->disk->directories())->toHaveCount(1);
});
