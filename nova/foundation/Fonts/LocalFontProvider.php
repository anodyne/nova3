<?php

declare(strict_types=1);

namespace Nova\Foundation\Fonts;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Nova\Foundation\Fonts\Contracts\FontProvider;

class LocalFontProvider implements FontProvider
{
    public function getFontHtml(string $family, ?string $url = null): Htmlable
    {
        $family = str($family)->kebab()->lower();
        $url = asset('dist/fonts/'.$family.'/font.css');

        return new HtmlString("<link href=\"{$url}\" rel=\"stylesheet\">");
    }

    public function getPreconnectHtml(): ?Htmlable
    {
        return null;
    }
}
