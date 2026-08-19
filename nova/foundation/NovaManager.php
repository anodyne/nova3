<?php

declare(strict_types=1);

namespace Nova\Foundation;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Nova\Characters\Models\Character;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Foundation\Environment\Environment;
use Nova\Foundation\Fonts\BunnyFontProvider;
use Nova\Foundation\Fonts\Contracts\FontProvider;
use Nova\Foundation\Fonts\GoogleFontProvider;
use Nova\Foundation\Fonts\LocalFontProvider;
use Nova\Foundation\Models\SystemInfo;
use Nova\Users\Models\User;
use Throwable;

class NovaManager
{
    public function adminScripts($options = []): string
    {
        $debug = config('app.debug');

        $scripts = $this->javaScriptAdminAssets($options);

        // HTML Label.
        $html = $debug ? ['<!-- Nova Scripts -->'] : [];

        // JavaScript assets.
        $html[] = $debug ? $scripts : $this->minify($scripts);

        return implode("\n", $html);
    }

    public function adminStyles($options = []): string
    {
        $debug = config('app.debug');

        $styles = $this->cssAdminAssets();

        // HTML Label.
        $html = $debug ? ['<!-- Nova Styles -->'] : [];

        // CSS assets.
        $html[] = $debug ? $styles : $this->minify($styles);

        return implode("\n", $html);
    }

    public function characterCount(): int
    {
        return once(fn () => Character::count());
    }

    public function databaseIsConfigured(?string $connection = null): bool
    {
        if (is_null($connection)) {
            $connection = Config::get('database.default');
        }

        return filled($database = Config::get("database.connections.{$connection}.database"))
            && filled($username = Config::get("database.connections.{$connection}.username"))
            && $database !== 'unconfigured'
            && $username !== 'username';
    }

    public function databaseVersion(): ?string
    {
        return SystemInfo::first()?->version;
    }

    public function environment(): Environment
    {
        return once(fn (): Environment => Environment::make());
    }

    public function filesVersion(): string
    {
        return config('nova.version');
    }

    public function getAvatarUrl(?string $seed = null): string
    {
        return sprintf(
            'https://api.dicebear.com/10.x/%s/svg?seed=%s',
            settings('appearance.avatarStyle')->value ?? 'big-ears-neutral',
            str_replace(' ', '', $seed ?? 'nova3')
        );
    }

    public function getBodyFontFamily(): string
    {
        return settings('appearance.fontFamily') ?? 'Inter';
    }

    public function getFontFamily(): string
    {
        return settings('appearance.fontFamily') ?? 'Inter';
    }

    public function getFontHtml(): Htmlable
    {
        return $this->getFontProvider()->getFontHtml(
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

    public function getHeaderFontFamily(): string
    {
        return settings('appearance.fontFamily') ?? 'Inter';
    }

    public function isInstalled(): bool
    {
        try {
            return once(fn () => Schema::hasTable('migrations'));
        } catch (Throwable) {
            return false;
        }
    }

    public function isUpdating(): bool
    {
        return Cache::has(CacheKeys::LatestVersion->value);
    }

    /**
     * Provide data from the backend for the frontend to use.
     */
    public function provideScriptVariables(): Collection
    {
        $theme = app('nova.theme');

        return collect([
            'page' => request()->route()->findPageFromRoute(),
            'theme' => $theme,
            'user' => Auth::user(),
        ]);
    }

    public function publicScripts($options = []): string
    {
        $debug = config('app.debug');

        $scripts = $this->javaScriptPublicAssets($options);

        // HTML Label.
        $html = $debug ? ['<!-- Nova Scripts -->'] : [];

        // JavaScript assets.
        $html[] = $debug ? $scripts : $this->minify($scripts);

        return implode("\n", $html);
    }

    public function publicStyles($options = []): string
    {
        $debug = config('app.debug');

        $styles = $this->cssPublicAssets();

        // HTML Label.
        $html = $debug ? ['<!-- Nova Styles -->'] : [];

        // CSS assets.
        $html[] = $debug ? $styles : $this->minify($styles);

        return implode("\n", $html);
    }

    public function setupScripts($options = []): string
    {
        $debug = config('app.debug');

        $scripts = $this->javaScriptSetupAssets($options);

        // HTML Label.
        $html = $debug ? ['<!-- Nova Scripts -->'] : [];

        // JavaScript assets.
        $html[] = $debug ? $scripts : $this->minify($scripts);

        return implode("\n", $html);
    }

    public function userCount(): int
    {
        return once(fn () => User::count());
    }

    protected function cssAdminAssets(): string
    {
        $appUrl = url('');
        $appStylesPath = "{$appUrl}/dist/css/admin.css";

        return <<<HTML
<link href="{$appStylesPath}" rel="stylesheet">
HTML;
    }

    protected function cssPublicAssets(): string
    {
        $appUrl = url('');
        $appStylesPath = "{$appUrl}/dist/css/public.css";

        return <<<HTML
<link href="{$appStylesPath}" rel="stylesheet">
HTML;
    }

    protected function javaScriptAdminAssets($options): string
    {
        $options ? json_encode($options) : '';

        $appUrl = url('');
        $jsPath = "{$appUrl}/dist/js/app.js";

        // Adding semicolons for this JavaScript is important,
        // because it will be minified in production.
        return <<<HTML
<script src="{$jsPath}" defer></script>
HTML;
    }

    protected function javaScriptPublicAssets($options): string
    {
        $options ? json_encode($options) : '';

        $appUrl = url('');
        $jsPath = "{$appUrl}/dist/js/app.js";

        // Adding semicolons for this JavaScript is important,
        // because it will be minified in production.
        return <<<HTML
<script src="{$jsPath}" defer></script>
HTML;
    }

    protected function javaScriptSetupAssets($options): string
    {
        $options ? json_encode($options) : '';

        $appUrl = url('');
        $jsPath = "{$appUrl}/dist/js/setup.js";

        // Adding semicolons for this JavaScript is important,
        // because it will be minified in production.
        return <<<HTML
<script src="{$jsPath}"></script>
HTML;
    }

    protected function minify($subject): string|array|null
    {
        return preg_replace('~(\v|\t|\s{2,})~m', '', $subject);
    }
}
