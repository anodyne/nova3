<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Nova\Foundation\Enums\ReleaseSeverity;

class ChangelogSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        activity()->disableLogging();

        $versions = [
            [
                'version' => '3.0.0',
                'series' => '3.0',
                'severity' => ReleaseSeverity::Major,
                'description' => 'Introducing Nova 3. The culmination of almost 10 years of work, Nova 3 is a modern take on RPG management built on Laravel 12 and Livewire 3.',
                'notes' => 'A complete rewrite with a modern UI, modular architecture, and full support for PHP 8.4.',
                'tags' => ['major release', 'new features'],
                'release_date' => '2025-01-01',
            ],
            [
                'version' => '3.0.1',
                'series' => '3.0',
                'severity' => ReleaseSeverity::Patch,
                'description' => 'Fixed an issue where notifications failed to render when a post author had been deleted.',
                'notes' => '',
                'tags' => ['bug fixes'],
                'release_date' => '2025-01-05',
            ],
            [
                'version' => '3.0.2',
                'series' => '3.0',
                'severity' => ReleaseSeverity::Patch,
                'description' => 'Resolved a caching bug that caused themes to not update immediately after saving changes.',
                'notes' => '',
                'tags' => ['bug fixes', 'performance'],
                'release_date' => '2025-01-10',
            ],
            [
                'version' => '3.0.3',
                'series' => '3.0',
                'severity' => ReleaseSeverity::Patch,
                'description' => 'Fixed an error preventing user bios from being submitted during onboarding.',
                'notes' => '',
                'tags' => ['bug fixes'],
                'release_date' => '2025-01-15',
            ],
            [
                'version' => '3.0.4',
                'series' => '3.0',
                'severity' => ReleaseSeverity::Patch,
                'description' => 'Improved API response times for large story lists and fixed an issue with pagination state.',
                'notes' => '',
                'tags' => ['performance', 'bug fixes'],
                'release_date' => '2025-01-25',
            ],
            [
                'version' => '3.1.0',
                'series' => '3.1',
                'severity' => ReleaseSeverity::Minor,
                'description' => 'Added the new Theme Builder and color palette system for customizing Nova’s interface.',
                'notes' => 'Also introduces a redesigned dashboard with configurable widgets.',
                'tags' => ['new features', 'quality of life'],
                'release_date' => '2025-02-10',
            ],
            [
                'version' => '3.1.1',
                'series' => '3.1',
                'severity' => ReleaseSeverity::Patch,
                'description' => 'Fixed minor UI inconsistencies in the new dashboard widgets and improved color contrast in dark mode.',
                'notes' => '',
                'tags' => ['bug fixes', 'accessibility'],
                'release_date' => '2025-02-14',
            ],
            [
                'version' => '3.2.0',
                'series' => '3.2',
                'severity' => ReleaseSeverity::Minor,
                'description' => 'Introduced the modular onboarding system allowing multiple onboarding processes for users and characters.',
                'notes' => 'Developers can now define custom steps via configuration or Livewire components.',
                'tags' => ['new features', 'developer tools'],
                'release_date' => '2025-03-05',
            ],
            [
                'version' => '3.2.1',
                'series' => '3.2',
                'severity' => ReleaseSeverity::Patch,
                'description' => 'Resolved an issue where onboarding progress was not resetting when users switched processes.',
                'notes' => '',
                'tags' => ['bug fixes'],
                'release_date' => '2025-03-10',
            ],
            [
                'version' => '3.3.0',
                'series' => '3.3',
                'severity' => ReleaseSeverity::Minor,
                'description' => 'Added full activity feed support with real-time updates powered by Laravel Echo.',
                'notes' => 'This update also adds filtering and grouping options for user notifications.',
                'tags' => ['new features', 'real-time'],
                'release_date' => '2025-04-02',
            ],
            [
                'version' => '3.3.1',
                'series' => '3.3',
                'severity' => ReleaseSeverity::Patch,
                'description' => 'Fixed a regression where unread notifications were not being marked as read after viewing.',
                'notes' => '',
                'tags' => ['bug fixes'],
                'release_date' => '2025-04-06',
            ],
            [
                'version' => '3.4.0',
                'series' => '3.4',
                'severity' => ReleaseSeverity::Minor,
                'description' => 'Introduced the new Story Manager, combining story organization, timelines, and post management into a single view.',
                'notes' => 'The update also includes improved rank handling and department editing features.',
                'tags' => ['new features', 'ui overhaul'],
                'release_date' => '2025-05-10',
            ],
            [
                'version' => '3.4.1',
                'series' => '3.4',
                'severity' => ReleaseSeverity::Patch,
                'description' => 'Fixed an issue where story sorting failed when custom order columns were not set.',
                'notes' => '',
                'tags' => ['bug fixes'],
                'release_date' => '2025-05-15',
            ],
            [
                'version' => '3.4.2',
                'series' => '3.4',
                'severity' => ReleaseSeverity::Patch,
                'description' => 'Improved database query performance for large story hierarchies.',
                'notes' => '',
                'tags' => ['performance'],
                'release_date' => '2025-05-22',
            ],
            [
                'version' => '3.5.0',
                'series' => '3.5',
                'severity' => ReleaseSeverity::Minor,
                'description' => 'Added support for multi-tenancy and per-tenant configuration isolation.',
                'notes' => 'This release introduces tenant-aware caching and scoped media directories.',
                'tags' => ['new features', 'infrastructure'],
                'release_date' => '2025-06-12',
            ],
            [
                'version' => '3.5.1',
                'series' => '3.5',
                'severity' => ReleaseSeverity::Patch,
                'description' => 'Fixed tenant ID not being applied to queued jobs created from Livewire components.',
                'notes' => '',
                'tags' => ['bug fixes'],
                'release_date' => '2025-06-18',
            ],
            [
                'version' => '3.6.0',
                'series' => '3.6',
                'severity' => ReleaseSeverity::Minor,
                'description' => 'Added the new “Tour System” powered by Shepherd.js, with modular step definitions per page.',
                'notes' => 'Admins can now onboard users interactively through guided tours.',
                'tags' => ['new features', 'ux enhancements'],
                'release_date' => '2025-07-05',
            ],
            [
                'version' => '3.6.1',
                'series' => '3.6',
                'severity' => ReleaseSeverity::Patch,
                'description' => 'Fixed broken tooltips on multi-step tours when translations were missing.',
                'notes' => '',
                'tags' => ['bug fixes', 'i18n'],
                'release_date' => '2025-07-09',
            ],
            [
                'version' => '3.6.2',
                'series' => '3.6',
                'severity' => ReleaseSeverity::Dependency,
                'description' => 'Updated to Filament v4.2 and Tailwind v4 final release.',
                'notes' => 'Also upgraded to Alpine.js 3.14 for improved reactivity.',
                'tags' => ['dependencies', 'performance'],
                'release_date' => '2025-07-20',
            ],
            [
                'version' => '3.7.0',
                'series' => '3.7',
                'severity' => ReleaseSeverity::Minor,
                'description' => 'Major improvements to the Book Tracking module, adding support for reading goals and completion stats.',
                'notes' => 'Also includes visual refinements to the Filament panels and quick search navigation.',
                'tags' => ['new features', 'ui updates', 'performance'],
                'release_date' => '2025-08-12',
            ],
        ];

        $now = Date::now()->setMicrosecond(0)->toDateTimeString();

        $rows = array_map(function (array $values) use ($now) {
            $severity = $values['severity'];
            $severity = $severity->value;

            return [
                'version' => $values['version'],
                'series' => $values['series'],
                'severity' => $severity,
                'description' => $values['description'],
                'notes' => $values['notes'],
                'tags' => json_encode($values['tags'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                'release_date' => $values['release_date'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $versions);

        DB::table('external_changelog')->upsert(
            $rows,
            ['version'],
            ['series', 'severity', 'description', 'notes', 'tags', 'release_date', 'updated_at']
        );

        activity()->enableLogging();
    }
}
