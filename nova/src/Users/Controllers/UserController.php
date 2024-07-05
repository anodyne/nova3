<?php

declare(strict_types=1);

namespace Nova\Users\Controllers;

use Illuminate\Support\Facades\Gate;
use Nova\Forms\Models\Form;
use Nova\Foundation\Controllers\Controller;
use Nova\Users\Actions\CreateUserManager;
use Nova\Users\Actions\UpdateUserManager;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Events\UserUpdatedByAdmin;
use Nova\Users\Models\User;
use Nova\Users\Requests\StoreUserRequest;
use Nova\Users\Requests\UpdateUserRequest;
use Nova\Users\Responses\CreateUserResponse;
use Nova\Users\Responses\EditUserResponse;
use Nova\Users\Responses\ListUsersResponse;
use Nova\Users\Responses\ShowUserResponse;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(User::class);
    }

    public function index()
    {
        return ListUsersResponse::send();
    }

    public function show(User $user)
    {
        return ShowUserResponse::sendWith([
            'user' => $user->load('roles', 'latestLogin', 'latestPost', 'userFormSubmission')->loadCount('activeCharacters', 'characters', 'publishedPosts'),
            'publishedPosts' => $user->publishedPosts()->take(5)->get(),
            'form' => Form::key('userBio')->first(),
        ]);
    }

    public function create()
    {
        return CreateUserResponse::sendWith([
            'form' => Form::key('userBio')->first(),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = CreateUserManager::run($request);

        UserCreatedByAdmin::dispatch($user);

        $redirect = redirect()
            ->notify("An account for {$user->name} was created", 'The user has been notified of their account and their password.');

        if (Gate::allows('update', $user)) {
            return $redirect->route('users.edit', $user);
        }

        return $redirect->route('users.index');
    }

    public function edit(User $user)
    {
        return EditUserResponse::sendWith([
            'user' => $user->load('roles', 'characters', 'userFormSubmission'),
            'form' => Form::key('userBio')->first(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user = UpdateUserManager::run($user, $request);

        UserUpdatedByAdmin::dispatch($user);

        return back()->notify("{$user->name}'s account was updated");
    }
}
