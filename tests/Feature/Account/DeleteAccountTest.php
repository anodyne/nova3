<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Applications\Models\Application;
use Nova\Characters\Models\Character;
use Nova\Discussions\Models\DiscussionNotification;
use Nova\Foundation\Models\StatusHistory;
use Nova\Notes\Models\Note;
use Nova\Onboarding\Actions\FinishOnboarding;
use Nova\Onboarding\Actions\StartOnboarding;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Onboarding\Models\Onboarding;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;
use Nova\Users\Livewire\DeleteMyAccount;
use Nova\Users\Models\Login;
use Nova\Users\Models\User;
use Nova\Users\Notifications\UserDeletedAccount;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\assertNotSoftDeleted;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('account');

beforeEach(function () {
    signIn(permissions: 'post.view');

    $this->user = Auth::user();
});

test('a user can view the delete account page', function () {
    get(route('admin.account.delete'))
        ->assertSuccessful()
        ->assertSeeLivewire(DeleteMyAccount::class);
});

test('a user can delete their own account', function () {
    Notification::fake();

    $admin = createUser(attributes: ['email' => 'admin@example.com'], permissions: 'user.update');

    livewire(DeleteMyAccount::class)->call('delete');

    assertSoftDeleted(User::class, [
        'id' => $this->user->id,
    ]);

    assertNotSoftDeleted(User::class, [
        'id' => $admin->id,
    ]);

    Notification::assertSentTo($admin, UserDeletedAccount::class);

    assertGuest();
});

test('users with update permissions are notified', function () {
    Notification::fake();

    $admin1 = createUser(attributes: ['email' => 'admin1@example.com'], permissions: 'user.update');
    $admin2 = createUser(attributes: ['email' => 'admin2@example.com'], permissions: 'user.update');
    $admin3 = createUser(attributes: ['email' => 'admin3@example.com'], permissions: 'user.update');

    $regularUser = createUser(attributes: ['email' => 'regular@example.com']);

    livewire(DeleteMyAccount::class)->call('delete');

    Notification::assertSentTo([$admin1, $admin2, $admin3], UserDeletedAccount::class);
    Notification::assertNotSentTo($regularUser, UserDeletedAccount::class);
});

test('deleted user is redirected to home with notification', function () {
    Notification::fake();

    createUser(permissions: 'user.update');

    livewire(DeleteMyAccount::class)
        ->call('delete')
        ->assertRedirect('/')
        ->assertNotified('Your user account has been deleted');
});

describe('data cleanup', function () {
    test('draft announcements are deleted', function () {
        Notification::fake();

        Announcement::factory()->draft()->create([
            'user_id' => $this->user->id,
        ]);

        createUser(permissions: 'user.update');

        livewire(DeleteMyAccount::class)->call('delete');

        assertDatabaseMissing(Announcement::class, [
            'user_id' => $this->user->id,
        ]);
    });

    test('pending announcements are deleted', function () {
        Notification::fake();

        Announcement::factory()->pending()->create([
            'user_id' => $this->user->id,
        ]);

        createUser(permissions: 'user.update');

        livewire(DeleteMyAccount::class)->call('delete');

        assertDatabaseMissing(Announcement::class, [
            'user_id' => $this->user->id,
        ]);
    });

    test('announcement notifications are deleted', function () {
        Notification::fake();

        $announcement = Announcement::factory()->published()->create();

        AnnouncementNotification::create([
            'announcement_id' => $announcement->id,
            'user_id' => $this->user->id,
            'is_seen' => false,
        ]);

        createUser(permissions: 'user.update');

        livewire(DeleteMyAccount::class)->call('delete');

        assertDatabaseMissing(AnnouncementNotification::class, [
            'user_id' => $this->user->id,
        ]);
    });

    test('applications work without error', function () {
        Notification::fake();

        $character = Character::factory()->primary()->active()->create();
        $character->users()->attach($this->user);

        $application = Application::factory()->create([
            'character_id' => $character->id,
            'user_id' => $this->user->id,
        ]);

        $user = createUser(permissions: 'user.update');

        $application->reviews()->sync([$user]);

        livewire(DeleteMyAccount::class)->call('delete');

        actingAs($user);

        get(route('admin.applications.show', $application))
            ->assertSuccessful()
            ->assertDontSee($this->user->name);
    });

    test('characters are updated', function () {
        Notification::fake();

        $character = Character::factory()->primary()->active()->create();
        $character->users()->attach($this->user);

        $user = createUser(permissions: ['user.update', 'character.view']);

        livewire(DeleteMyAccount::class)->call('delete');

        actingAs($user);

        get(route('admin.characters.show', $character))
            ->assertSuccessful()
            ->assertDontSee($this->user->name);
    })->todo();

    test('discussions are updated', function () {
        assertDatabaseMissing(DiscussionNotification::class, [
            'user_id' => $this->user->id,
        ]);
    })->todo();

    test('logins are removed', function () {
        Notification::fake();

        $this->user->recordLogin('127.0.0.1');

        createUser(permissions: 'user.update');

        livewire(DeleteMyAccount::class)->call('delete');

        assertDatabaseMissing(Login::class, [
            'user_id' => $this->user->id,
        ]);
    });

    test('notes are removed', function () {
        Notification::fake();

        $this->user->notes()->create([
            'title' => 'Test Note 1',
            'content' => 'Content 1',
        ]);

        $this->user->notes()->create([
            'title' => 'Test Note 2',
            'content' => 'Content 2',
        ]);

        createUser(permissions: 'user.update');

        livewire(DeleteMyAccount::class)->call('delete');

        assertDatabaseMissing(Note::class, [
            'user_id' => $this->user->id,
        ]);
    });

    test('onboarding processes are removed', function () {
        Notification::fake();

        $onboarding1 = StartOnboarding::run(OnboardingProcess::NewUser, $this->user);
        FinishOnboarding::run($onboarding1);

        StartOnboarding::run(OnboardingProcess::NewUser, $this->user);

        createUser(permissions: 'user.update');

        livewire(DeleteMyAccount::class)->call('delete');

        assertDatabaseMissing(Onboarding::class, [
            'user_id' => $this->user->id,
        ]);
    });

    test('status histories are removed', function () {
        Notification::fake();

        $this->user->statusHistories()->create([
            'status' => 'active',
            'started_at' => now()->subMonths(2),
            'ended_at' => now()->subMonth(),
        ]);

        $this->user->statusHistories()->create([
            'status' => 'active',
            'started_at' => now()->subWeeks(2),
        ]);

        createUser(permissions: 'user.update');

        livewire(DeleteMyAccount::class)->call('delete');

        assertDatabaseMissing(StatusHistory::class, [
            'statusable_type' => 'user',
            'statusable_id' => $this->user->id,
        ]);
    });

    test('story posts with the deleted user as an author can display without error', function () {
        Notification::fake();

        $story = Story::factory()->current()->create();

        $post = Post::factory()->published()->make([
            'story_id' => $story->id,
        ]);
        $post->save();
        $post->userAuthors()->attach($this->user);

        get(route('admin.posts.show', [$story, $post]))
            ->assertSuccessful()
            ->assertDontSee('Deleted user');

        $user = createUser(permissions: ['user.update', 'post.view']);

        livewire(DeleteMyAccount::class)->call('delete');

        actingAs($user);

        get(route('admin.posts.show', [$story, $post]))
            ->assertSuccessful()
            ->assertSeeText('Deleted user');
    });

    test('story posts with the deleted user as an author with an alias name still display the alias', function () {
        Notification::fake();

        $story = Story::factory()->current()->create();

        $post = Post::factory()->published()->make([
            'story_id' => $story->id,
        ]);
        $post->save();
        $post->userAuthors()->attach($this->user, ['as' => 'Martok']);

        get(route('admin.posts.show', [$story, $post]))
            ->assertSuccessful()
            ->assertDontSee('Deleted user');

        $user = createUser(permissions: ['user.update', 'post.view']);

        livewire(DeleteMyAccount::class)->call('delete');

        actingAs($user);

        get(route('admin.posts.show', [$story, $post]))
            ->assertSuccessful()
            ->assertDontSeeText('Deleted user')
            ->assertSeeText('Martok');
    });

    test('user avatar is removed', function () {
        Notification::fake();
        Storage::fake('media');

        $this->user->addMedia(UploadedFile::fake()->image('avatar.jpg'))
            ->toMediaCollection('avatar');

        expect($this->user->getFirstMedia('avatar'))->not->toBeNull();

        createUser(permissions: 'user.update');

        livewire(DeleteMyAccount::class)->call('delete');

        assertDatabaseMissing('media', [
            'model_type' => 'user',
            'model_id' => $this->user->id,
            'collection_name' => 'avatar',
        ]);
    });
});
