<?php

declare(strict_types=1);

use Symfony\Component\Finder\Finder;

test('migrations do not define down() methods', function (): void {
    $migrationsPath = dirname(__DIR__, 2).'/nova/database/migrations';

    $finder = Finder::create()
        ->files()
        ->name('*.php')
        ->in($migrationsPath);

    $violations = [];

    foreach ($finder as $file) {
        $contents = file_get_contents($file->getRealPath());
        if ($contents === false) {
            continue;
        }

        if (preg_match('/function\s+down\s*\(/', $contents) === 1) {
            $violations[] = 'database/migrations/'.$file->getRelativePathname();
        }
    }

    expect($violations)->toBeEmpty();
});
