<?php

declare(strict_types=1);
use Nova\Departments\Actions\DeletePosition;
use Nova\Departments\Models\Position;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->position = Position::factory()->create();
});
it('deletes a position', function () {
    $position = DeletePosition::run($this->position);

    expect($position->exists)->toBeFalse();
});
