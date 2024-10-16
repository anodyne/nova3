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
     * The extensions path for the Nova installation.
     *
     * @var string
     */
    protected $extensionPath;

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
     * Get the path to the extensions directory.
     */
    public function extensionPath(string $path = ''): string
    {
        return $this->joinPaths($this->extensionPath ?: $this->basePath('extensions'), $path);
    }

    /**
     * Set the extensions directory.
     *
     * @return $this
     */
    public function useExtensionPath(string $path): self
    {
        $this->extensionPath = $path;

        $this->instance('path.extensions', $path);

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

    /**
     * Are we using the secure skeleton?
     */
    public function usesSecureSkeleton(): bool
    {
        return is_dir(base_path('public'));
    }

    /**
     * Are we using the simple skeleton?
     */
    public function usesSimpleSkeleton(): bool
    {
        return ! $this->usesSecureSkeleton();
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
        return $this['nova']->getVersion();
    }
}
