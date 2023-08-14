<?php

declare(strict_types=1);
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Models\States\Status\Inactive;
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Models\User;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->active()->create();

    $character1 = Character::factory()->active()->create();
    $character2 = Character::factory()->active()->create();
    $character3 = Character::factory()->active()->create();

    $this->user->characters()->attach($character1);
    $this->user->characters()->attach($character2);
    $this->user->characters()->attach($character3);
});
it('deactivates all characters for a user', function () {
    $user = DeactivateUser::run($this->user);

    expect($user->characters->where('status', Inactive::$name))->toHaveCount(3);
    expect($user->characters->where('status', Active::$name))->toHaveCount(0);
});
