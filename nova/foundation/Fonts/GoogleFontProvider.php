<?php

declare(strict_types=1);

namespace Nova\Foundation\Fonts;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class GoogleFontProvider implements Contracts\FontProvider
{
    public function getFontHtml(string $family, ?string $url = null): Htmlable
    {
        $family = str($family)->replace(' ', '+');
        $url ??= "https://fonts.googleapis.com/css2?family={$family}:wght@400;500;600;700;800;900&display=swap";

        return new HtmlString("<link href=\"{$url}\" rel=\"stylesheet\">");
    }

    public function getPreconnectHtml(): ?Htmlable
    {
        return new HtmlString('<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>');
    }
}
