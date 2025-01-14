<?php

declare(strict_types=1);

namespace Nova\Foundation;

use Composer\InstalledVersions;
use Illuminate\Foundation\Application as IlluminateApplication;

class Application extends IlluminateApplication
{
    /**
     * The nova path for the Nova installation.
     *
     * @var string
     */
    protected $novaPath;

    /**
     * The themes path for the Nova installation.
     *
     * @var string
     */
    protected $themePath;

    /**
     * The add-ons path for the Nova installation.
     *
     * @var string
     */
    protected $addonPath;

    /**
     * The ranks path for the Nova installation.
     *
     * @var string
     */
    protected $rankPath;

    /**
     * Get the path to the nova directory.
     */
    public function novaPath(string $path = ''): string
    {
        return $this->joinPaths($this->novaPath ?: $this->basePath('nova'), $path);
    }

    /**
     * Set the nova directory.
     *
     * @return $this
     */
    public function useNovaPath(string $path): self
    {
        $this->novaPath = $path;

        $this->instance('path.nova', $path);

        return $this;
    }

    /**
     * Get the path to the themes directory.
     */
    public function themePath(string $path = ''): string
    {
        return $this->joinPaths($this->themePath ?: $this->basePath('themes'), $path);
    }

    /**
     * Set the themes directory.
     *
     * @return $this
     */
    public function useThemePath(string $path): self
    {
        $this->themePath = $path;

        $this->instance('path.themes', $path);

        return $this;
    }

    /**
     * Get the path to the add-ons directory.
     */
    public function addonPath(string $path = ''): string
    {
        return $this->joinPaths($this->addonPath ?: $this->basePath('addons'), $path);
    }

    /**
     * Set the add-ons directory.
     *
     * @return $this
     */
    public function useAddonPath(string $path): self
    {
        $this->addonPath = $path;

        $this->instance('path.addons', $path);

        return $this;
    }

    /**
     * Get the path to the ranks directory.
     */
    public function rankPath(string $path = ''): string
    {
        return $this->joinPaths($this->rankPath ?: $this->basePath('ranks'), $path);
    }

    /**
     * Set the ranks directory.
     *
     * @return $this
     */
    public function useRankPath(string $path): self
    {
        $this->rankPath = $path;

        $this->instance('path.ranks', $path);

        return $this;
    }

    /**
     * Get the path to the resources directory.
     *
     * NOTE: We override this method so that we can move the resources folder
     * into the nova folder.
     *
     * @param  string  $path
     * @return string
     */
    public function resourcePath($path = '')
    {
        return $this->joinPaths($this->novaPath('resources'), $path);
    }

    /**
     * Get the path to the bootstrap directory.
     *
     * NOTE: We override this because it is not possible to change the
     * bootstrap path before the providers file is loaded.
     *
     * @param  string  $path
     * @return string
     */
    public function bootstrapPath($path = '')
    {
        return $this->joinPaths($this->novaPath('bootstrap'), $path);
    }

    public function filamentVersion(): string
    {
        return str(InstalledVersions::getPrettyVersion('filament/support'))->after('v')->toString();
    }

    public function livewireVersion(): string
    {
        return str(InstalledVersions::getPrettyVersion('livewire/livewire'))->after('v')->toString();
    }

    public function novaVersion(): string
    {
        return $this['nova']->filesVersion();
    }
}
