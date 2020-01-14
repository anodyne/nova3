<?php

namespace Nova\Foundation;

use Illuminate\Foundation\PackageManifest;
use Illuminate\Foundation\Application as IlluminateApp;

class Application extends IlluminateApp
{
    /**
     * Bind all of the application paths in the container.
     *
     * NOTE: We override this method so that we can bind additional paths into
     * the Laravel container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        parent::bindPathsInContainer();

        $this->instance('path.nova', $this->novaPath());
    }

    /**
     * Get the path to the bootstrap directory.
     *
     * NOTE: We override this method so that we can move the bootstrap folder
     * into the nova folder.
     *
     * @param  string  $path Optionally, a path to append to the bootstrap path
     * @return string
     */
    public function bootstrapPath($path = '')
    {
        return $this->novaPath('bootstrap').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the application configuration files.
     *
     * NOTE: We override this method so that we can move the config folder into
     * the nova folder.
     *
     * @param  string  $path Optionally, a path to append to the config path
     * @return string
     */
    public function configPath($path = '')
    {
        return $this->novaPath('config').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the database directory.
     *
     * NOTE: We override this method so that we can move the database folder
     * into the nova folder.
     *
     * @param  string  $path Optionally, a path to append to the database path
     * @return string
     */
    public function databasePath($path = '')
    {
        return ($this->databasePath ?: $this->novaPath('database')).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the base path of the Nova installation.
     *
     * @param  string  $path Optionally, a path to append to the Nova path
     * @return string
     */
    public function novaPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'nova'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the application "app" directory.
     *
     * NOTE: We override this method so that we can point the "app" folder at
     * the src folder in the nova directory.
     *
     * @param  string  $path Optionally, a path to append to the app path
     * @return string
     */
    public function path($path = '')
    {
        return $this->novaPath('src').($path ? DIRECTORY_SEPARATOR.$path : $path);
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
        return $this->novaPath('resources').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the themes directory.
     *
     * @param  string  $path
     * @return string
     */
    public function themePath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'themes'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}