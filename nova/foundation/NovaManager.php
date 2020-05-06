<?php

namespace Nova\Foundation;

class NovaManager
{
    public $version = '3.0.0';

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

    protected function javaScriptAssets($options)
    {
        $jsonEncodedOptions = $options ? json_encode($options) : '';

        $appUrl = url('');
        $jsPath = "{$appUrl}/dist/js/app-server.js";
        $processResponsePath = "{$appUrl}/nova/resources/js/process-response.js";

        // Adding semicolons for this JavaScript is important,
        // because it will be minified in production.
        return <<<HTML
<script data-turbolinks-eval="false">
    window.nova_app_url = '{$appUrl}';
</script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.3.1/dist/alpine.min.js" data-turbolinks-eval="false" defer></script>
<script src="{$jsPath}" data-turbolinks-eval="false" defer></script>
<script src="{$processResponsePath}" data-turbolinks-eval="false"></script>
HTML;
    }

    protected function minify($subject)
    {
        return preg_replace('~(\v|\t|\s{2,})~m', '', $subject);
    }
}
