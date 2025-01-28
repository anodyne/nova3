<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Facades\Artisan;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Data\AddonData;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Exceptions\AddonAlreadyExistsException;
use Nova\Addons\Exceptions\AddonRanksAlreadyExistsException;
use Throwable;

class SetupAddonDirectory
{
    use AsAction;

    protected FilesystemAdapter $files;

    public string $commandSignature = 'nova:make-addon
                                       {name : The name of the add-on}
                                       {--location= : Set a custom location for the add-on}
                                       {--preview= : Set a custom preview image name for the add-on}';

    public string $commandDescription = 'Scaffold a new add-on.';

    protected AddonData $data;

    public function __construct(FilesystemManager $files)
    {
        $this->files = $files->disk('addons');
    }

    public function handle(AddonData $data): void
    {
        $this->data = $data;

        try {
            $this->createAddonDirectory();

            match ($data->type) {
                AddonType::Extension => $this->createExtension(),
                AddonType::Genre => $this->createGenre(),
                AddonType::Rank => $this->createRankSet(),
                default => null,
            };
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function asCommand(Command $command): void
    {
        try {
            $this->handle(AddonData::from([
                'name' => $command->argument('name'),
                'location' => $command->option('location'),
                'preview' => $command->option('preview'),
            ]));

            $command->info('Add-on scaffold created successfully.');
        } catch (Throwable $th) {
            $command->error($th->getMessage());
        }
    }

    protected function createExtension(): void
    {
        $this->createServiceProvider();

        $this->createMigrations();

        $this->createAddonClass(AddonType::Extension);
    }

    protected function createGenre(): void
    {
        $this->createRanksDirectory();

        $this->createAddonClass(AddonType::Genre);
    }

    protected function createRankSet(): void
    {
        $this->createRanksDirectory();

        $this->createAddonClass(AddonType::Rank);
    }

    protected function createAddonDirectory(): void
    {
        $location = $this->getAddonLocation();

        throw_if(
            $this->files->exists($location),
            new AddonAlreadyExistsException($location)
        );

        $this->files->makeDirectory($location);
    }

    protected function createRanksDirectory(): void
    {
        $location = $this->getAddonLocation().DIRECTORY_SEPARATOR.'ranks';

        throw_if(
            $this->files->exists($location),
            new AddonRanksAlreadyExistsException($location)
        );

        $this->files->makeDirectory($location);
    }

    protected function createAddonInstallFile(): void
    {
        $this->makeFileFromStub(
            stubFile: 'addon.json.stub',
            path: '/addon.json'
        );
    }

    protected function createAddonClass(AddonType $type): void
    {
        $this->makeFileFromStub(
            stubFile: match ($type) {
                AddonType::Extension => 'extension.php.stub',
                AddonType::Genre => 'genre.php.stub',
                AddonType::Rank => 'rankset.php.stub',
                default => 'addon.php.stub',
            },
            path: '/Addon.php'
        );
    }

    protected function createServiceProvider(): void
    {
        $this->makeDirectory('/Providers');

        $this->makeFileFromStub(
            stubFile: 'service-provider.php.stub',
            path: '/Providers/AddonServiceProvider.php'
        );
    }

    protected function createMigrations(): void
    {
        $this->makeDirectory('/Migrations');

        Artisan::call('make:migration', [
            'name' => 'InitialMigrationFor'.$this->getAddonName(),
            '--path' => 'addons/'.$this->getAddonLocation().'/Migrations',
        ]);
    }

    protected function getAddonLocation(): string
    {
        if ($location = $this->data->location) {
            return $location;
        }

        return $this->getAddonName();
    }

    protected function getAddonName(): string
    {
        return $this->data->name;
    }

    protected function makeDirectory(string $path): void
    {
        $this->files->makeDirectory($this->getAddonLocation().$path);
    }

    protected function makeFileFromStub(string $stubFile, string $path): void
    {
        $stub = file_get_contents(__DIR__.'/../stubs/'.$stubFile);

        $stub = str_replace(
            ['DummyNamespace', 'DummyLocation', 'DummyPreview', 'DummyName'],
            [
                $this->getAddonLocation(),
                $this->getAddonLocation(),
                $this->data->preview,
                $this->getAddonName(),
            ],
            $stub
        );

        $this->files->put($this->getAddonLocation().$path, $stub);
    }
}
