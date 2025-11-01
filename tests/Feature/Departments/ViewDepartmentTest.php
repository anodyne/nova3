<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Users\Models\User;

use function Pest\Laravel\get;

uses()->group('departments');

beforeEach(function () {
    $this->department = Department::factory()->hasPositions(5)->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.view');
    });

    test('can view the view department page', function () {
        get(route('admin.departments.show', $this->department))->assertSuccessful();
    });

    test('can see positions assigned to the department', function () {
        $response = get(route('admin.departments.show', $this->department));

        foreach ($this->department->positions as $position) {
            $response->assertSeeText($position->name);
        }
    });

    test('can only see active characters assigned to the department positions', function () {
        Event::fake();

        foreach ($this->department->positions as $position) {
            $activeCharacter = Character::factory()->active()->create();
            $inactiveCharacter = Character::factory()->inactive()->create();

            $position->characters()->attach($activeCharacter);
            $position->characters()->attach($inactiveCharacter);
        }

        $this->department->refresh();
        $this->department->loadMissing('positions', 'positions.activeCharacters', 'positions.characters');

        $response = get(route('admin.departments.show', $this->department));

        foreach ($this->department->positions as $position) {
            expect($position->activeCharacters->count())->toBe(1);
            expect($position->characters->count())->toBe(2);

            $response->assertSeeText($position->activeCharacters->first()->name);
            $response->assertDontSeeText($position->characters->where('status', 'inactive')->first()->name);
        }
    });

    test('can only see active users assigned to characters assigned to the department positions', function () {
        Event::fake();

        $user = User::factory()->active()->create([
            'name' => 'AgentPhoenix',
        ]);

        $feryn = Character::factory()->inactive()->create([
            'name' => 'Tal Feryn',
        ]);
        $feryn->users()->attach($user);

        $reardon = Character::factory()->active()->create([
            'name' => 'William Reardon',
        ]);
        $reardon->users()->attach($user);

        $command = Department::factory()->active()->create([
            'name' => 'Command',
        ]);
        $commandPosition = Position::factory()->active()->create([
            'name' => 'Commanding Officer',
            'department_id' => $command->id,
        ]);
        $commandPosition->characters()->attach($reardon);

        $engineering = Department::factory()->active()->create([
            'name' => 'Engineering',
        ]);
        $engineeringPosition = Position::factory()->active()->create([
            'name' => 'Chief Engineer',
            'department_id' => $engineering->id,
        ]);
        $engineeringPosition->characters()->attach($feryn);

        expect($command->activeUsers->count())->toBe(1);
        expect($command->users->count())->toBe(1);

        expect($engineering->activeUsers->count())->toBe(0);
        expect($engineering->users->count())->toBe(1);

        get(route('admin.departments.show', $command))
            ->assertSeeText('AgentPhoenix');

        get(route('admin.departments.show', $engineering))
            ->assertDontSeeText('AgentPhoenix');
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the view department page', function () {
        get(route('admin.departments.show', $this->department))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view department page', function () {
        get(route('admin.departments.show', $this->department))
            ->assertRedirectToRoute('login');
    });
});
