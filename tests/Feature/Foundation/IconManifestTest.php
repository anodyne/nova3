<?php

declare(strict_types=1);

use BladeUI\Icons\IconsManifest;
use Illuminate\Support\Facades\Blade;

test('application refreshes reuse the icon manifest and preserve icon rendering', function (): void {
    $manifest = app(IconsManifest::class);
    $icon = svg('tabler-check')->toHtml();

    $this->refreshApplication();
    $this->refreshApplication();

    expect(app(IconsManifest::class))->toBe($manifest);
    expect(svg('tabler-check')->toHtml())->toContain('<svg')->toBe($icon);
    expect(Blade::compileString('<x-tabler-check />'))->toContain('BladeUI\\Icons\\Components\\Svg');
});
