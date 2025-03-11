<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Foundation\Enums\ReleaseSeverity;
use Nova\Foundation\Models\ExternalChangelog;

class ChangelogSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $versions = [
            ['version' => '3.0.0', 'series' => '3.0', 'severity' => ReleaseSeverity::Major, 'description' => 'Introducing Nova 3. The culmination of almost 10 years of work, Nova 3 is a modern take on RPG management.', 'notes' => '', 'tags' => [], 'release_date' => '2025-01-01'],
            ['version' => '3.0.1', 'series' => '3.0', 'severity' => ReleaseSeverity::Patch, 'description' => 'Adipisicing mollit do duis consectetur in cupidatat sint velit quis. Labore dolore irure sunt duis tempor culpa est Lorem fugiat commodo occaecat et laboris velit occaecat.', 'notes' => '', 'tags' => ['bug fixes'], 'release_date' => '2025-01-03'],
            ['version' => '3.0.2', 'series' => '3.0', 'severity' => ReleaseSeverity::Patch, 'description' => 'Ex dolor cupidatat aliquip aliquip dolor in.', 'notes' => '', 'tags' => ['bug fixes'], 'release_date' => '2025-01-10'],
            ['version' => '3.0.3', 'series' => '3.0', 'severity' => ReleaseSeverity::Patch, 'description' => 'Nulla ipsum pariatur eu aliqua et exercitation in consectetur laboris ad eu fugiat sint labore velit. Non nostrud dolore ipsum exercitation voluptate. Irure qui occaecat consequat consectetur quis sint non reprehenderit.', 'notes' => '', 'tags' => ['bug fixes'], 'release_date' => '2025-01-12'],
            ['version' => '3.0.4', 'series' => '3.0', 'severity' => ReleaseSeverity::Patch, 'description' => 'Anim est aute esse anim ullamco exercitation commodo sint eiusmod. Ullamco sit eu reprehenderit non adipisicing officia eu pariatur nulla enim.', 'notes' => '', 'tags' => ['bug fixes', 'quality of life'], 'release_date' => '2025-01-22'],
            ['version' => '3.0.5', 'series' => '3.0', 'severity' => ReleaseSeverity::Dependency, 'description' => '', 'notes' => '', 'tags' => [], 'release_date' => '2025-01-31'],
            ['version' => '3.0.6', 'series' => '3.0', 'severity' => ReleaseSeverity::Dependency, 'description' => '', 'notes' => '', 'tags' => [], 'release_date' => '2025-02-04'],
            ['version' => '3.1.0', 'series' => '3.1', 'severity' => ReleaseSeverity::Minor, 'description' => 'Nova 3.1 is the first minor update for Nova 3 and includes several new features.', 'notes' => '', 'tags' => ['new features', 'bug fixes', 'quality of life'], 'release_date' => '2025-02-14'],
        ];

        collect($versions)->each([ExternalChangelog::class, 'create']);

        activity()->enableLogging();
    }
}
