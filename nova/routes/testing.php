<?php

use Nova\Users\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

Route::get('auth', function () {
    return auth()->user();
});

Route::get('create/{model}', function ($model) {
    $model = str_replace('-', '\\', $model);

    return factory($model)->create(request()->all());
});

Route::get('login', function () {
    $user = factory(User::class)->create(request()->all());

    auth()->login($user);

    return $user;
});

Route::get('login-with-permissions', function () {
    $user = factory(User::class)->create();

    $permissions = (is_string(request()->get('permissions')))
        ? [request()->get('permissions')]
        : request()->get('permissions');

    $user->attachPermissions($permissions);

    auth()->login($user);
});

Route::get('logout', function () {
    auth()->logout();
});

Route::get('create-reset-token/{user}', function (User $user) {
    return response()->json(['token' => Password::broker()->createToken($user)]);
});
