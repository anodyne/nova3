<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Exceptions\ThemeException;
use RuntimeException;
use Throwable;

class SetupThemeDirectory
{
    use AsAction;

    public string $commandDescription = 'Scaffold a new theme.';

    public string $commandSignature = 'nova:make-theme
                                       {name : The name of the theme}
                                       {--location= : Set a custom location for the theme}
                                       {--preview= : Set a custom preview image name for the theme}
                                       {--variants=* : Set the variants for the theme}';

    protected ThemeData $data;

    protected Filesystem $files;

    public function __construct(FilesystemManager $files)
    {
        $this->files = $files->disk('themes');
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

    public function handle(ThemeData $data): void
    {
        $this->data = $data;
        $this->createThemeDirectory();
        $this->createThemeInstallFile();
        $this->createThemeClass();
        $this->createThemeDesignDirectoryAndStylesheet();
        $this->createThemeLayout();
    }

    protected function createStylesheet(string $stylesheet): void
    {
        $stub = $this->readStub('theme.css.stub');

        $this->files->put($this->getThemeLocation()."/design/{$stylesheet}", $stub);
    }

    protected function createThemeClass(): void
    {
        $stub = $this->readStub('theme.php.stub');

        $stub = str_replace(
            ['DummyNamespace', 'DummyLocation'],
            [$this->getThemeLocation(), $this->getThemeLocation()],
            $stub
        );

        $this->files->put($this->getThemeLocation().'/Theme.php', $stub);
    }

    protected function createThemeDesignDirectoryAndStylesheet(): void
    {
        $this->files->makeDirectory($this->getThemeLocation().'/design');

        $this->createStylesheet('theme.css');
    }

    protected function createThemeDirectory(): void
    {
        $location = $this->getThemeLocation();

        throw_if(
            $this->files->exists($location),
            ThemeException::themeAlreadyExists($location)
        );

        $this->files->makeDirectory($location);
    }

    protected function createThemeInstallFile(): void
    {
        $stub = $this->readStub('theme.json.stub');

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

    protected function createThemeLayout(): void
    {
        $this->files->makeDirectory($this->getThemeLocation().'/views/components/layouts');

        $stub = $this->readStub('theme-layout.blade.php.stub');

        $stub = str_replace(
            ['DummyLocation'],
            [$this->getThemeLocation()],
            $stub
        );

        $this->files->put($this->getThemeLocation().'/views/components/layouts/theme.blade.php', $stub);
    }

    protected function readStub(string $stubFile): string
    {
        $path = __DIR__.'/../stubs/'.$stubFile;
        $contents = file_get_contents($path);

        if ($contents === false) {
            throw new RuntimeException("Unable to read theme stub [{$path}].");
        }

        return $contents;
    }

    protected function getThemeLocation(): string
    {
        if ($location = $this->data->location) {
            return $location;
        }

        return $this->getThemeName();
    }

    protected function getThemeName(): string
    {
        return $this->data->name;
    }
}
