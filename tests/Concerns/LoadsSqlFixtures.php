<?php

declare(strict_types=1);

namespace Tests\Concerns;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RuntimeException;

trait LoadsSqlFixtures
{
    protected function loadFixture(string $filename, string $connection = 'nova2'): void
    {
        $path = base_path("tests/fixtures/nova2/{$filename}");

        if (! File::exists($path)) {
            throw new RuntimeException("Fixture file not found: {$path}");
        }

        // https://x.com/_newtonjob/status/1990378189638770883
        DB::connection($connection)->getSchemaState()->load($path);

        //        $sql = File::get($path);

        //        DB::connection($connection)->unprepared($sql);
    }

    protected function loadFixtures(array $filenames, string $connection = 'nova2'): void
    {
        foreach ($filenames as $filename) {
            $this->loadFixture($filename, $connection);
        }
    }

    protected function loadAllFixtures(string $directory, string $connection = 'nova2'): void
    {
        $path = base_path('tests/fixtures/nova2');
        $files = File::glob("{$path}/*.sql");

        foreach ($files as $file) {
            $sql = File::get($file);
            DB::connection($connection)->unprepared($sql);
        }
    }

    protected function clearNova2Database(): void
    {
        DB::connection('nova2')->statement('SET FOREIGN_KEY_CHECKS=0');

        $tables = DB::connection('nova2')->select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            DB::connection('nova2')->table($tableName)->truncate();
        }

        DB::connection('nova2')->statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
