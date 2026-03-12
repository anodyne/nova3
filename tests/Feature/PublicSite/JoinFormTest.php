<?php

declare(strict_types=1);

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\RateLimiter;
use Nova\Applications\Models\Application;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\CharacterPosition;
use Nova\Characters\Models\CharacterUser;
use Nova\Departments\Models\Position;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('applications');
uses()->group('public-site');
uses()->group('join');

test('can view the join page', function () {
    get(route('public.join'))
        ->assertSeeText('Join')
        ->assertViewHas('selectedPosition', null)
        ->assertSuccessful();
});

test('cannot view the join page if it is disabled from settings', function () {
    updateSettings(function ($settings) {
        $settings->applications = $settings->applications->with(
            enabled: false,
            disabledMessage: 'Joining has been disabled'
        );

        return $settings;
    });

    expect(settings('applications.enabled'))->toBeFalse();

    get(route('public.join'))
        ->assertSeeText('Joining has been disabled')
        ->assertSuccessful();
});

test('cannot send a POST request to the join page if it is disabled from settings', function () {
    updateSettings(function ($settings) {
        $settings->applications = $settings->applications->with(
            enabled: false,
            disabledMessage: 'Joining has been disabled'
        );

        return $settings;
    });

    expect(settings('applications.enabled'))->toBeFalse();

    $position = Position::factory()->create();

    post(route('public.join.process'), [
        'userInfo' => [
            'name' => 'Patrick Stewart',
            'email' => 'patrick.stewart@example.test',
            'password' => 'password',
        ],
        'characterInfo' => [
            'name' => 'Jean-Luc Picard',
            'positions' => [$position->id],
        ],
    ])
        ->assertNotFound();
});

test('can load the join page with a pre-filled position', function () {
    $position = Position::factory()->create();

    get(route('public.join', $position))
        ->assertViewHas('selectedPosition', $position->id)
        ->assertSuccessful();
});

test('can submit the join form', function () {
    $position = Position::factory()->create();

    get(route('public.join'))
        ->assertSeeText('Join')
        ->assertSuccessful();

    from(route('public.join'))
        ->followingRedirects()
        ->post(route('public.join.process'), [
            'userInfo' => [
                'name' => 'Patrick Stewart',
                'email' => 'patrick.stewart@example.test',
                'password' => 'password',
            ],
            'characterInfo' => [
                'name' => 'Jean-Luc Picard',
                'positions' => [$position->id],
            ],
        ])
        ->assertSuccessful();

    $application = Application::latest()->first();
    $character = Character::latest()->first();
    $user = User::latest()->first();

    assertDatabaseHas(Application::class, [
        'id' => $application->id,
    ]);

    assertDatabaseHas(User::class, [
        'name' => 'Patrick Stewart',
        'email' => 'patrick.stewart@example.test',
        'status' => 'pending',
    ]);

    assertDatabaseHas(Character::class, [
        'name' => 'Jean-Luc Picard',
        'status' => 'pending',
    ]);

    assertDatabaseHas(CharacterPosition::class, [
        'character_id' => $character->id,
        'position_id' => $position->id,
    ]);

    assertDatabaseHas(CharacterUser::class, [
        'user_id' => $user->id,
        'character_id' => $character->id,
        'primary' => 1,
    ]);
});

test('existing user submissions are attached to their user account', function () {
    $user = User::factory()->active()->create();

    $position = Position::factory()->create();

    get(route('public.join'))
        ->assertSeeText('Join')
        ->assertSuccessful();

    from(route('public.join'))
        ->followingRedirects()
        ->post(route('public.join.process'), [
            'userInfo' => [
                'name' => 'Patrick Stewart',
                'email' => $user->email,
                'password' => 'password',
            ],
            'characterInfo' => [
                'name' => 'Jean-Luc Picard',
                'positions' => [$position->id],
            ],
        ])
        ->assertSuccessful();

    $application = Application::latest()->first();
    $character = Character::latest()->first();

    assertDatabaseHas(Application::class, [
        'id' => $application->id,
    ]);

    assertDatabaseHas(User::class, [
        'name' => $user->name,
        'email' => $user->email,
        'status' => 'active',
    ]);

    assertDatabaseHas(Character::class, [
        'name' => 'Jean-Luc Picard',
        'status' => 'pending',
    ]);

    assertDatabaseHas(CharacterPosition::class, [
        'character_id' => $character->id,
        'position_id' => $position->id,
    ]);

    assertDatabaseHas(CharacterUser::class, [
        'user_id' => $user->id,
        'character_id' => $character->id,
        'primary' => 1,
    ]);
});

describe('rate limits', function () {
    test('by email address', function () {
        $position = Position::factory()->create();

        from(route('public.join'))
            ->followingRedirects()
            ->post(route('public.join.process'), [
                'userInfo' => [
                    'name' => 'Patrick Stewart',
                    'email' => 'patrick.stewart@example.test',
                    'password' => 'password',
                ],
                'characterInfo' => [
                    'name' => 'Jean-Luc Picard',
                    'positions' => [$position->id],
                ],
            ])
            ->assertSuccessful();

        from(route('public.join'))
            ->followingRedirects()
            ->post(route('public.join.process'), [
                'userInfo' => [
                    'name' => 'Patrick Stewart',
                    'email' => 'patrick.stewart@example.test',
                    'password' => 'password',
                ],
                'characterInfo' => [
                    'name' => 'Jean-Luc Picard II',
                    'positions' => [$position->id],
                ],
            ])
            ->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);
    });

    test('by IP address', function () {
        RateLimiter::for('join', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        $position = Position::factory()->create();

        for ($i = 0; $i < 3; $i++) {
            from(route('public.join'))
                ->followingRedirects()
                ->post(route('public.join.process'), [
                    'userInfo' => [
                        'name' => "User {$i}",
                        'email' => "user{$i}@example.test",
                        'password' => 'password',
                    ],
                    'characterInfo' => [
                        'name' => "Character {$i}",
                        'positions' => [$position->id],
                    ],
                ])
                ->assertSuccessful();
        }

        from(route('public.join'))
            ->followingRedirects()
            ->post(route('public.join.process'), [
                'userInfo' => [
                    'name' => 'Throttled User',
                    'email' => 'throttled@example.test',
                    'password' => 'password',
                ],
                'characterInfo' => [
                    'name' => 'Throttled Character',
                    'positions' => [$position->id],
                ],
            ])
            ->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);
    });
});
