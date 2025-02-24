<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Addons\Actions\BustActiveAddonsCache;
use Nova\Addons\Actions\InstallAddon;
use Nova\Addons\Models\Addon;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Themes\Actions\InstallTheme;
use Nova\Themes\Models\Theme;
use Symfony\Component\Finder\Finder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $this->installThemes();

        $this->installExtensions();

        $this->installGenreData();

        $this->call([
            UserSeeder::class,
            NoteSeeder::class,

            CharacterSeeder::class,

            StorySeeder::class,
            PostSeeder::class,
            FormSeeder::class,

            ApplicationSeeder::class,

            DiscussionSeeder::class,

            AnnouncementSeeder::class,

            ChangelogSeeder::class,
        ]);

        activity()->enableLogging();
    }

    protected function installThemes(): void
    {
        if (Theme::count() === 0) {
            $finder = new Finder;
            $finder->in(theme_path())
                ->directories()
                ->depth(0);

            collect($finder)
                ->flatMap(fn ($finder) => [$finder->getFilename()])
                ->reject(fn ($theme) => ! file_exists(theme_path($theme.'/theme.json')))
                ->each([InstallTheme::class, 'run']);
        }
    }

    protected function installExtensions(): void
    {
        if (Addon::count() === 0) {
            $finder = new Finder;
            $finder->in(addon_path())
                ->directories()
                ->depth(0);

            collect($finder)
                ->flatMap(fn ($finder) => [$finder->getFilename()])
                ->reject(fn ($addon) => ! file_exists(addon_path($addon.'/addon.json')))
                ->each([InstallAddon::class, 'run']);

            BustActiveAddonsCache::run();
        }
    }

    protected function installGenreData(): void
    {
        // $this->call([
        //     RankGroupSeeder::class,
        //     RankNameSeeder::class,
        //     RankItemSeeder::class,

        //     DepartmentSeeder::class,
        //     PositionSeeder::class,
        // ]);

        if (Department::count() === 0 && Position::count() === 0) {
            $genre = Addon::location('St25')->first();
            $genre?->runScript('install');
        }
    }
}
