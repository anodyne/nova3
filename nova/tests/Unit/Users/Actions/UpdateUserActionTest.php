<?php

declare(strict_types=1);
use Nova\Users\Actions\UpdateUser;
use Nova\Users\Data\PronounsData;
use Nova\Users\Data\UserData;
use Nova\Users\Models\User;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->active()->create();
});
it('updates a user', function () {
    $data = UserData::from([
        'name' => 'John Public',
        'email' => 'john@example.com',
        'pronouns' => PronounsData::from(['value' => 'neutral']),
    ]);

    $user = UpdateUser::run($this->user, $data);

    expect($user->name)->toEqual('John Public');
    expect($user->email)->toEqual('john@example.com');
    expect($user->pronouns->value)->toEqual('neutral');
});
