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
    protected $themesPath;

    /**
     * The extensions path for the Nova installation.
     *
     * @var string
     */
    protected $extensionsPath;

    /**
     * Get the path to the nova directory.
     *
     * @param  string  $path
     * @return string
     */
    public function novaPath(string $path = ''): string
    {
        return ($this->novaPath ?: $this->basePath.DIRECTORY_SEPARATOR.'nova').($path != '' ? DIRECTORY_SEPARATOR.$path : '');
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
        return ($this->themesPath ?: $this->basePath.DIRECTORY_SEPARATOR.'themes').($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

    /**
     * Set the themes directory.
     *
     * @param  string  $path
     * @return $this
     */
    public function useThemesPath(string $path): self
    {
        $this->themesPath = $path;

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
        return ($this->extensionsPath ?: $this->basePath.DIRECTORY_SEPARATOR.'extensions').($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

    /**
     * Set the extensions directory.
     *
     * @param  string  $path
     * @return $this
     */
    public function useExtensionsPath(string $path): self
    {
        $this->extensionsPath = $path;

        $this->instance('path.extensions', $path);

        return $this;
    }

    /**
     * Get the path to the bootstrap directory.
     *
     * NOTE: We override this method so that we can move the bootstrap folder
     * into the nova folder.
     *
     * @param  string  $path
     * @return string
     */
    public function bootstrapPath($path = '')
    {
        return $this->novaPath('bootstrap').($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

    /**
     * Get the path to the application configuration files.
     *
     * NOTE: We override this method so that we can move the config folder into
     * the nova folder.
     *
     * @param  string  $path
     * @return string
     */
    public function configPath($path = '')
    {
        return $this->novaPath('config').($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

    /**
     * Get the path to the public / web directory.
     *
     * NOTE: We override this method so that we can move the public folder
     * to the root directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->basePath;
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
        return $this->novaPath('resources').($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

    /**
     * Bind all of the application paths in the container.
     *
     * NOTE: We override this method so that we can bind additional paths into
     * the Laravel container.
     *
     * @return void
     */
    protected function bindPathsInContainer(): void
    {
        $this->useNovaPath(path: $this->basePath('nova'));
        $this->useThemesPath(path: $this->basePath('themes'));
        $this->useExtensionsPath(path: $this->basePath('extensions'));

        $this->useAppPath(path: $this->novaPath('src'));
        $this->useDatabasePath(path: $this->novaPath('database'));

        parent::bindPathsInContainer();

        $this->useLangPath(path: $this->novaPath('lang'));
    }
}
