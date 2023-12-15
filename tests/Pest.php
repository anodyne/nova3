<?php

declare(strict_types=1);

use Nova\Users\Actions\PopulateAccountPreferences;
use Nova\Users\Actions\PopulateNotificationPreferences;
use Nova\Users\Models\User;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createUser(array $attributes = [], mixed $permissions = '', bool $admin = false)
{
    $user = User::factory()->active()->create($attributes);

    PopulateAccountPreferences::run($user);
    PopulateNotificationPreferences::run($user);

    if ($admin) {
        $user->addRole('admin');
    }

    if (filled($permissions)) {
        $permissions = (is_string($permissions)) ? [$permissions] : $permissions;

        $user->givePermissions($permissions);
    }

    return $user;
}

function makeUser(array $attributes = [])
{
    return User::factory()->make($attributes);
}

function signIn(array $attributes = [], mixed $permissions = '', bool $admin = false)
{
    return test()->actingAs(
        createUser(
            attributes: $attributes,
            permissions: $permissions,
            admin: $admin
        )
    );
}
