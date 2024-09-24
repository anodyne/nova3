<?php

declare(strict_types=1);

namespace Nova\Foundation;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Schema;
use Nova\Foundation\Environment\Environment;
use Nova\Foundation\Fonts\BunnyFontProvider;
use Nova\Foundation\Fonts\Contracts\FontProvider;
use Nova\Foundation\Fonts\GoogleFontProvider;
use Nova\Foundation\Fonts\LocalFontProvider;
use Throwable;

class NovaManager
{
    public string $version = '3.0.0-alpha11';

    public function environment(): Environment
    {
        return once(fn () => Environment::make());
    }

    public function getAvatarUrl(?string $seed = null): string
    {
        return sprintf(
            'https://api.dicebear.com/9.x/%s/svg?seed=%s',
            settings('appearance.avatarStyle')->value,
            str_replace(' ', '', $seed ?? 'nova3')
        );
    }

    public function getFontFamily(): string
    {
        return settings('appearance.fontFamily') ?? 'Inter';
    }

    public function getBodyFontFamily(string $section): string
    {
        return settings('appearance.fontFamily') ?? 'Inter';
    }

    public function getHeaderFontFamily(string $section): string
    {
        return settings('appearance.fontFamily') ?? 'Inter';
    }

    public function getFontHtml(): Htmlable
    {
        return $this->getFontProvider()->getHtml(
            $this->getFontFamily()
        );
    }

    public function getFontProvider(): FontProvider
    {
        return match (settings('appearance.fontProvider')) {
            'bunny' => new BunnyFontProvider,
            'google' => new GoogleFontProvider,
            default => new LocalFontProvider,
        };
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function isInstalled(): bool
    {
        try {
            return Schema::hasTable('migrations');
        } catch (Throwable $th) {
            return false;
        }
    }

    public function adminStyles($options = [])
    {
        $debug = config('app.debug');

        $styles = $this->cssAdminAssets();

        // HTML Label.
        $html = $debug ? ['<!-- Nova Styles -->'] : [];

        // CSS assets.
        $html[] = $debug ? $styles : $this->minify($styles);

        return implode("\n", $html);
    }

    public function adminScripts($options = [])
    {
        $debug = config('app.debug');

        $scripts = $this->javaScriptAdminAssets($options);

        // HTML Label.
        $html = $debug ? ['<!-- Nova Scripts -->'] : [];

        // JavaScript assets.
        $html[] = $debug ? $scripts : $this->minify($scripts);

        return implode("\n", $html);
    }

    public function publicStyles($options = [])
    {
        $debug = config('app.debug');

        $styles = $this->cssPublicAssets();

        // HTML Label.
        $html = $debug ? ['<!-- Nova Styles -->'] : [];

        // CSS assets.
        $html[] = $debug ? $styles : $this->minify($styles);

        return implode("\n", $html);
    }

    public function publicScripts($options = [])
    {
        $debug = config('app.debug');

        $scripts = $this->javaScriptPublicAssets($options);

        // HTML Label.
        $html = $debug ? ['<!-- Nova Scripts -->'] : [];

        // JavaScript assets.
        $html[] = $debug ? $scripts : $this->minify($scripts);

        return implode("\n", $html);
    }

    /**
     * Provide data from the backend for the frontend to use.
     *
     * @return \Illuminate\Support\Collection
     */
    public function provideScriptVariables()
    {
        $theme = app('nova.theme');

        return collect([
            'icons' => $theme->iconMap(),
            'page' => request()->route()->findPageFromRoute(),
            'theme' => $theme,
            'user' => auth()?->user(),
        ]);
    }

    protected function cssAdminAssets()
    {
        $appUrl = url('');
        $appStylesPath = "{$appUrl}/dist/css/app.css";

        return <<<HTML
<link href="{$appStylesPath}" rel="stylesheet">
HTML;
    }

    protected function cssPublicAssets()
    {
        $appUrl = url('');
        $appStylesPath = "{$appUrl}/dist/css/public.css";

        return <<<HTML
<link href="{$appStylesPath}" rel="stylesheet">
HTML;
    }

    protected function javaScriptAdminAssets($options)
    {
        $jsonEncodedOptions = $options ? json_encode($options) : '';

        $appUrl = url('');
        $jsPath = "{$appUrl}/dist/js/app.js";

        // Adding semicolons for this JavaScript is important,
        // because it will be minified in production.
        return <<<HTML
<script src="{$jsPath}" defer></script>
HTML;
    }

    protected function javaScriptPublicAssets($options)
    {
        $jsonEncodedOptions = $options ? json_encode($options) : '';

        $appUrl = url('');
        $jsPath = "{$appUrl}/dist/js/app.js";

        // Adding semicolons for this JavaScript is important,
        // because it will be minified in production.
        return <<<HTML
<script src="{$jsPath}" defer></script>
HTML;
    }

    protected function minify($subject)
    {
        return preg_replace('~(\v|\t|\s{2,})~m', '', $subject);
    }
}
