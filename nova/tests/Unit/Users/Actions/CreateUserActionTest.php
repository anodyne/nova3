<?php

declare(strict_types=1);
use Nova\Users\Actions\CreateUser;
use Nova\Users\Data\PronounsData;
use Nova\Users\Data\UserData;
it('creates a new user', function () {
    $data = UserData::from([
        'name' => 'John Public',
        'email' => 'john@example.com',
        'pronouns' => PronounsData::from(['value' => 'neutral']),
    ]);

    $user = CreateUser::run($data);

    expect($user->name)->toEqual('John Public');
    expect($user->email)->toEqual('john@example.com');
    expect($user->pronouns->value)->toEqual('neutral');
});
