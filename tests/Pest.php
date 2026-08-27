<?php

declare(strict_types=1);

use Nova\Users\Actions\PopulateAccountPreferences;
use Nova\Users\Actions\PopulateNotificationPreferences;
use Nova\Users\Models\User;
use Tests\TestCase;

pest()
    ->extend(TestCase::class)
    ->beforeEach(function (): void {
        $this->withoutVite();
        $this->freezeTime();
    })
    ->in('Feature', 'Unit');

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

function signInAs(User $user)
{
    return test()->actingAs($user);
}

function updateSettings(callable $callback)
{
    $settings = settings();

    $settings = $callback($settings);

    $settings->save();
}

function themePayload(array $overrides = []): array
{
    $data = [
        'name' => 'Test Theme',
        'location' => 'TestTheme',
        'version' => '1.0',
        'preview' => 'preview.png',
        'credits' => 'Test credits',
        'status' => 'true',
        'settings' => [
            'fonts' => [
                'headerProvider' => 'local',
                'headerFamily' => 'Inter',
                'bodyProvider' => 'local',
                'bodyFamily' => 'Inter',
                'monoProvider' => 'local',
                'monoFamily' => 'Monaspace Neon',
            ],
        ],
    ];

    return array_replace_recursive($data, $overrides);
}
