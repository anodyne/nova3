<?php

declare(strict_types=1);
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
beforeEach(function () {
    $this->department = Department::factory()->create();

    $this->position1 = Position::factory()->create([
        'sort' => 0,
        'department_id' => $this->department,
    ]);
    $this->position2 = Position::factory()->create([
        'sort' => 1,
        'department_id' => $this->department,
    ]);
    $this->position3 = Position::factory()->create([
        'sort' => 2,
        'department_id' => $this->department,
    ]);
});
test('authorized user can reorder positions', function () {
    $this->signInWithPermission('department.update');

    $this->followingRedirects();

    $response = $this->post(
        route('positions.reorder', $this->department),
        [
            'sort' => implode(',', [
                $this->position3->id,
                $this->position2->id,
                $this->position1->id,
            ]),
        ]
    );
    $response->assertSuccessful();

    $this->position1->fresh();
    $this->position2->fresh();
    $this->position3->fresh();

    $this->assertDatabaseHas('positions', [
        'id' => $this->position1->id,
        'sort' => 2,
    ]);
    $this->assertDatabaseHas('positions', [
        'id' => $this->position2->id,
        'sort' => 1,
    ]);
    $this->assertDatabaseHas('positions', [
        'id' => $this->position3->id,
        'sort' => 0,
    ]);
});
test('unauthorized user cannot reorder positions', function () {
    $this->signIn();

    $response = $this->post(
        route('positions.reorder', $this->department),
        [
            'sort' => implode(',', [
                $this->position3->id,
                $this->position2->id,
                $this->position1->id,
            ]),
        ]
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot reorder positions', function () {
    $response = $this->postJson(
        route('positions.reorder', $this->department),
        [
            'sort' => implode(',', [
                $this->position3->id,
                $this->position2->id,
                $this->position1->id,
            ]),
        ]
    );
    $response->assertUnauthorized();
});
