<?php

declare(strict_types=1);

namespace Nova\Foundation\Fonts\Contracts;

use Illuminate\Contracts\Support\Htmlable;

interface FontProvider
{
    public function getFontHtml(string $family, ?string $url = null): Htmlable;

    public function getPreconnectHtml(): ?Htmlable;
}
