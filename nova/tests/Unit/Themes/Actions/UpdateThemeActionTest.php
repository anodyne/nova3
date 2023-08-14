<?php

declare(strict_types=1);
use Nova\Themes\Actions\UpdateTheme;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Models\Theme;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->theme = Theme::factory()->create();
});
it('updates a theme', function () {
    $data = ThemeData::from([
        'name' => 'Slate',
        'location' => 'slate',
        'credits' => 'Slate credits',
        'preview' => 'new-preview.jpg',
        'active' => false,
    ]);

    $theme = UpdateTheme::run($this->theme, $data);

    expect($theme->exists)->toBeTrue();
    expect($theme->name)->toEqual('Slate');
    expect($theme->location)->toEqual('slate');
    expect($theme->credits)->toEqual('Slate credits');
    expect($theme->preview)->toEqual('new-preview.jpg');
    expect($theme->active)->toBeFalse();
});
