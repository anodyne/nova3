<?php

declare(strict_types=1);

use Nova\Setup\Livewire\Migrations\MigrateUsers;
use Nova\Users\Models\User;
use Tests\Concerns\LoadsSqlFixtures;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

uses(LoadsSqlFixtures::class);
uses()->group('setup', 'migration');

it('migrates user data correctly', function () {
    $this->loadFixture('users.sql');

    MigrateUsers::run();

    assertDatabaseCount(User::class, 3);

    assertDatabaseHas(User::class, [
        'name' => 'janeway',
        'status' => 'active',
    ]);
})->todo();
