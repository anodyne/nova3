<?php

declare(strict_types=1);
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->active()->create();

    $this->activePrimaryCharacter = Character::factory()->active()->create();
    $this->activePrimaryCharacter->users()->attach($this->user, ['primary' => true]);

    $this->secondaryCharacter = Character::factory()->active()->create();
    $this->secondaryCharacter->users()->attach($this->user);

    $this->inactiveCharacter = Character::factory()->inactive()->create();
    $this->inactiveCharacter->users()->attach($this->user);

    $this->user->refresh();
});
it('can access all characters assigned to the user', function () {
    expect($this->user->characters)->toHaveCount(3);
});
it('can access only active characters assigned to the user', function () {
    expect($this->user->activeCharacters)->toHaveCount(2);
});
it('can access only active primary character assigned to the user', function () {
    expect($this->user->primaryCharacter)->toHaveCount(1);
});
