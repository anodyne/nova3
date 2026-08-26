<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Addons\Actions\BustActiveAddonsCache;
use Nova\Addons\Actions\InstallAddon;
use Nova\Addons\Models\Addon;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Onboarding\Actions\StartOnboarding;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Themes\Actions\InstallTheme;
use Nova\Themes\Models\Theme;
use Nova\Users\Models\User;
use Symfony\Component\Finder\Finder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
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
            CurrentStoriesPostSeeder::class,
            CompletedStoriesPostSeeder::class,

            FormSeeder::class,

            ApplicationSeeder::class,

            DiscussionSeeder::class,

            AnnouncementSeeder::class,

            ChangelogSeeder::class,

            NotificationSeeder::class,
        ]);

        StartOnboarding::run(OnboardingProcess::FreshInstall, User::first());

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
                ->flatMap(fn ($finder): array => [$finder->getFilename()])
                ->reject(fn ($theme): bool => ! file_exists(theme_path($theme.'/theme.json')))
                ->each(InstallTheme::run(...));
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
                ->flatMap(fn ($finder): array => [$finder->getFilename()])
                ->reject(fn ($addon): bool => ! file_exists(addon_path($addon.'/addon.json')))
                ->each(InstallAddon::run(...));

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

            $ranks = Addon::location('Picard2390')->first();
            $ranks?->runScript('install');
        }
    }
}
