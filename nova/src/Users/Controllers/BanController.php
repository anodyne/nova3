<?php

declare(strict_types=1);

namespace Nova\Users\Controllers;

use Nova\Forms\Models\Form;
use Nova\Foundation\Controllers\Controller;
use Nova\Users\Actions\CreateUserManager;
use Nova\Users\Actions\UpdateUserManager;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Events\UserUpdatedByAdmin;
use Nova\Users\Models\Ban;
use Nova\Users\Models\User;
use Nova\Users\Requests\StoreUserRequest;
use Nova\Users\Requests\UpdateUserRequest;
use Nova\Users\Responses\CreateBanResponse;
use Nova\Users\Responses\EditUserResponse;
use Nova\Users\Responses\ListBansResponse;
use Nova\Users\Responses\ShowUserResponse;

class BanController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Ban::class);
    }

    public function index()
    {
        return ListBansResponse::send();
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
        return CreateBanResponse::sendWith([
            'users' => User::active()->get(),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = CreateUserManager::run($request);

        UserCreatedByAdmin::dispatch($user);

        return to_route('admin.users.index')
            ->notify("An account for {$user->name} was created", 'The user has been notified of their account and their password.');
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
