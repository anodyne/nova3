<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Exceptions\ThemeException;
use Throwable;

class SetupThemeDirectory
{
    use AsAction;

    public string $commandSignature = 'nova:make-theme
                                       {name : The name of the theme}
                                       {--location= : Set a custom location for the theme}
                                       {--preview= : Set a custom preview image name for the theme}
                                       {--variants=* : Set the variants for the theme}';

    public string $commandDescription = 'Scaffold a new theme.';

    protected ThemeData $data;

    public function __construct(FilesystemManager $files)
    {
        $this->files = $files->disk('themes');
    }

    public function handle(ThemeData $data): void
    {
        $this->data = $data;

        try {
            $this->createThemeDirectory();

            $this->createThemeInstallFile();

            $this->createThemeClass();

            $this->createThemeDesignDirectoryAndStylesheet();

            $this->createThemeVariants();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function asCommand(Command $command): void
    {
        try {
            $this->handle(ThemeData::from([
                'name' => $command->argument('name'),
                'location' => $command->option('location'),
                'preview' => $command->option('preview'),
                'variants' => $command->option('variants'),
            ]));

            $command->info('Theme scaffold created successfully.');
        } catch (Throwable $th) {
            $command->error($th->getMessage());
        }
    }

    /**
     * Create the theme directory.
     *
     * @throws \Nova\Themes\Exceptions\ThemeException
     */
    protected function createThemeDirectory(): void
    {
        $location = $this->getThemeLocation();

        throw_if(
            $this->files->exists($location),
            ThemeException::themeAlreadyExists($location)
        );

        $this->files->makeDirectory($location);
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
            ['DummyName', 'DummyLocation', 'DummyPreview'],
            [
                $this->getThemeName(),
                $this->getThemeLocation(),
                $this->data->preview,
            ],
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
            [$this->getThemeLocation(), $this->getThemeLocation()],
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
        if ($variants = $this->data->variants) {
            $this->files->makeDirectory($this->getThemeLocation().'/design/variants');

            collect($variants)
                ->map(fn ($variant) => trim($variant))
                ->each(fn ($variant) => $this->createStylesheet("variants/{$variant}.css"));
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
     */
    protected function getThemeLocation(): string
    {
        if ($location = $this->data->location) {
            return strtolower($location);
        }

        return strtolower($this->getThemeName());
    }

    /**
     * Get the name of the theme.
     */
    protected function getThemeName(): string
    {
        return $this->data->name;
    }
}
