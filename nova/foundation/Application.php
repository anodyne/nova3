<?php

declare(strict_types=1);

namespace Nova\Foundation;

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
     *
     * @param  string  $path
     * @return string
     */
    public function novaPath(string $path = ''): string
    {
        return $this->joinPaths($this->novaPath ?: $this->basePath('nova'), $path);
    }

    /**
     * Set the nova directory.
     *
     * @param  string  $path
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
     *
     * @param  string  $path
     * @return string
     */
    public function themePath(string $path = ''): string
    {
        return $this->joinPaths($this->themePath ?: $this->basePath('themes'), $path);
    }

    /**
     * Set the themes directory.
     *
     * @param  string  $path
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
     *
     * @param  string  $path
     * @return string
     */
    public function extensionPath(string $path = ''): string
    {
        return $this->joinPaths($this->extensionPath ?: $this->basePath('extensions'), $path);
    }

    /**
     * Set the extensions directory.
     *
     * @param  string  $path
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
}
