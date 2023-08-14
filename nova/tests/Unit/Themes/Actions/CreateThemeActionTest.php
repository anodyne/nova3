<?php

declare(strict_types=1);
use Nova\Themes\Actions\CreateTheme;
use Nova\Themes\Data\ThemeData;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a theme', function () {
    $data = ThemeData::from([
        'name' => 'Foo',
        'location' => 'foo',
        'active' => true,
        'preview' => 'preview.jpg',
    ]);

    $theme = CreateTheme::run($data);

    expect($theme->exists)->toBeTrue();
    expect($theme->name)->toEqual('Foo');
    expect($theme->location)->toEqual('foo');
    expect($theme->active)->toBeTrue();
    expect($theme->preview)->toEqual('preview.jpg');
});
