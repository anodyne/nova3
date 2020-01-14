<?php

namespace Nova\Themes\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;
use Symfony\Component\Console\Input\InputOption;

class ThemeMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'nova:make:theme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold a new theme.';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\FilesystemManager  $files
     * @return void
     */
    public function __construct(FilesystemManager $files)
    {
        parent::__construct();

        $this->files = $files->disk('themes');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->createThemeDirectory();

            $this->createThemeInstallFile();

            $this->createThemeClass();

            $this->createThemeDesignDirectoryAndStylesheet();

            $this->createThemeVariants();

            $this->info('Theme scaffold created successfully.');
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Create the theme directory.
     *
     * @return void
     * @throws RuntimeException
     */
    protected function createThemeDirectory()
    {
        if ($this->files->exists($this->getThemeLocation())) {
            throw new \RuntimeException("Theme scaffold could not be created because the theme [{$this->getThemeLocation()}] already exists.");
        }

        $this->files->makeDirectory($this->getThemeLocation());
    }

    /**
     * Create the theme.json file.
     *
     * @return void
     */
    protected function createThemeInstallFile()
    {
        $stub = file_get_contents(__DIR__.'/../stubs/theme.json.stub');

        $stub = str_replace(
            ['DummyName', 'DummyLocation'],
            [$this->getThemeName(), $this->getThemeLocation()],
            $stub
        );

        $this->files->put($this->getThemeLocation().'/theme.json', $stub);
    }

    /**
     * Create the Theme.php file.
     *
     * @return void
     */
    protected function createThemeClass()
    {
        $stub = file_get_contents(__DIR__.'/../stubs/theme.php.stub');

        $stub = str_replace(
            ['DummyNamespace', 'DummyLocation'],
            [ucfirst($this->getThemeLocation()), $this->getThemeLocation()],
            $stub
        );

        $this->files->put($this->getThemeLocation().'/Theme.php', $stub);
    }

    /**
     * Create the design directory and add the custom.css file to it.
     *
     * @return void
     */
    protected function createThemeDesignDirectoryAndStylesheet()
    {
        $this->files->makeDirectory($this->getThemeLocation().'/design');

        $this->createStylesheet('custom.css');
    }

    /**
     * Create the variants directory and add the stylesheets.
     *
     * @return void
     */
    protected function createThemeVariants()
    {
        if ($variants = $this->option('variants')) {
            $this->files->makeDirectory($this->getThemeLocation().'/design/variants');

            collect($variants)->each(function ($variant) {
                $this->createStylesheet("variants/{$variant}.css");
            });
        }
    }

    /**
     * Create a new stylesheet.
     *
     * @param  string  $stylesheet
     * @return void
     */
    protected function createStylesheet($stylesheet)
    {
        $stub = file_get_contents(__DIR__.'/../stubs/custom.css.stub');

        $this->files->put($this->getThemeLocation()."/design/{$stylesheet}", $stub);
    }

    /**
     * Get the location of the theme.
     *
     * @return string
     */
    protected function getThemeLocation()
    {
        if ($location = $this->option('location')) {
            return strtolower($location);
        }

        return strtolower($this->getThemeName());
    }

    /**
     * Get the name of the theme.
     *
     * @return string
     */
    protected function getThemeName()
    {
        return $this->argument('name');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputOption::VALUE_REQUIRED, 'The name of the theme']
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['location', 'l', InputOption::VALUE_OPTIONAL, 'Set a custom location for the theme'],
            ['variants', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Set the variants for the theme'],
        ];
    }
}
