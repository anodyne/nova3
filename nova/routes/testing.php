<?php

use Nova\Users\Models\User;

Route::get('create/{model}', function ($model) {
    $model = str_replace('-', '\\', $model);

    return factory($model)->create(request()->all());
});

Route::get('login', function () {
    $user = factory(User::class)->create(request()->all());

    auth()->login($user);
});
