<?php

declare(strict_types=1);

namespace Nova\Foundation\Fonts;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class LocalFontProvider implements Contracts\FontProvider
{
    public function getHtml(string $family, string $url = null): Htmlable
    {
        $family = str($family)->kebab()->lower();
        $url = asset('dist/fonts/'.$family.'/font.css');

        return new HtmlString("
            <link href=\"{$url}\" rel=\"stylesheet\">
        ");
    }
}
