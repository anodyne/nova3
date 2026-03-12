<?php

declare(strict_types=1);

namespace Nova\Setup\Enums;

use Illuminate\Support\Facades\Blade;
use Nova\Setup\Steps\Install;
use Nova\Setup\Steps\Migrate;
use Nova\Setup\Steps\SetupSteps;
use Nova\Setup\Steps\Update;

enum SetupType: string
{
    case Install = 'install';

    case Migrate = 'migrate';

    case Update = 'update';

    public function getHelpIntro(): string
    {
        return match ($this) {
            self::Install => 'Check out the install guide or join the Discord server to get help with setting up Nova.',
            self::Migrate => 'Check out the migration guide or join the Discord server to get help with migrating your game.',
            self::Update => 'Check out the update guide or join the Discord server to get help with updating Nova.',
        };
    }

    public function getGuideButton(): string
    {
        return match ($this) {
            self::Install => Blade::render('<x-button href="'.config('services.anodyne.links.install-guide').'" target="_blank">Install guide</x-button>'),
            self::Migrate => Blade::render('<x-button href="'.config('services.anodyne.links.migrate-guide').'" target="_blank">Migrate guide</x-button>'),
            self::Update => Blade::render('<x-button href="'.config('services.anodyne.links.update-guide').'" target="_blank">Update guide</x-button>'),
        };
    }

    public function getSteps(): SetupSteps
    {
        return match ($this) {
            self::Install => new Install,
            self::Migrate => new Migrate,
            self::Update => new Update,
        };
    }
}
