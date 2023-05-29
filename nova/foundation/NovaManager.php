<?php

declare(strict_types=1);

namespace Nova\Foundation;

use Illuminate\Support\Facades\Schema;
use Throwable;

class NovaManager
{
    public $version = '3.0.0';

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

    public function styles($options = [])
    {
        $debug = config('app.debug');

        $styles = $this->cssAssets();

        // HTML Label.
        $html = $debug ? ['<!-- Nova Styles -->'] : [];

        // CSS assets.
        $html[] = $debug ? $styles : $this->minify($styles);

        return implode("\n", $html);
    }

    public function scripts($options = [])
    {
        $debug = config('app.debug');

        $scripts = $this->javaScriptAssets($options);

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
            'user' => auth()->user(),
        ]);
    }

    protected function cssAssets()
    {
        $appUrl = url('');
        $appStylesPath = "{$appUrl}/dist/css/app.css";

        return <<<HTML
<link href="https://rsms.me/inter/inter.css" rel="stylesheet">
<link href="{$appStylesPath}" rel="stylesheet">
HTML;
    }

    protected function javaScriptAssets($options)
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
