<?php

use Nova\Users\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('create/{model}', function ($model) {
    $model = str_replace('-', '\\', $model);

    return factory($model)->create(request()->all());
});

Route::get('login', function () {
    $user = factory(User::class)->create(request()->all());

    auth()->login($user);
});

Route::get('login-with-permissions', function () {
    $user = factory(User::class)->create();
    $user->attachPermission(request()->get('permissions'));

    auth()->login($user);
});

Route::get('logout', function () {
    auth()->logout();
});
