<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Notifications\AnnouncementPublished;
use Nova\Applications\Models\Application;
use Nova\Applications\Notifications\ApplicationAccepted;
use Nova\Applications\Notifications\ApplicationDenied;
use Nova\Applications\Notifications\ApplicationReadyForReview;
use Nova\Applications\Notifications\ApplicationReviewerVotedToAccept;
use Nova\Applications\Notifications\ApplicationReviewerVotedToDeny;
use Nova\Characters\Models\Character;
use Nova\Characters\Notifications\CharacterRequiresApproval;
use Nova\Characters\Notifications\PendingCharacterApproved;
use Nova\Characters\Notifications\PendingCharacterDenied;
use Nova\PublicSite\Notifications\SiteContactMessage;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;
use Nova\Stories\Notifications\CharacterAuthorAddedToPost;
use Nova\Stories\Notifications\CharacterAuthorRemovedFromPost;
use Nova\Stories\Notifications\DraftPostDiscarded;
use Nova\Stories\Notifications\PostPublished;
use Nova\Stories\Notifications\PostSaved;
use Nova\Stories\Notifications\StoryEnded;
use Nova\Stories\Notifications\StoryStarted;
use Nova\Stories\Notifications\UserAuthorAddedToPost;
use Nova\Stories\Notifications\UserAuthorRemovedFromPost;
use Nova\Users\Models\User;
use Nova\Users\Notifications\AccountCreated;
use Nova\Users\Notifications\UserDeletedAccount;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        activity()->disableLogging();

        DB::table('notifications')->truncate();

        $user = User::first();

        $activeUser = User::factory()->active()->create();

        $pendingUser = User::factory()->pending()->create();

        $pendingCharacter = Character::factory()->pending()->create();
        $pendingCharacter->users()->save($pendingUser);

        $activeCharacter = Character::factory()->active()->create();
        $activeCharacter->users()->save($activeUser);

        $story = Story::factory()->create();

        $post = Post::factory()->create(['story_id' => $story->id]);

        $application = Application::factory()->create();
        $application->reviews()->save($activeUser);

        $user->notify(new CharacterRequiresApproval(
            character: $pendingCharacter,
            user: $pendingUser
        ));

        $user->notify(new UserDeletedAccount(user: $activeUser));

        $user->notify(new SiteContactMessage(
            name: 'Jack Sparrow',
            email: 'jack.sparrow@example.com',
            subjectLine: 'Site Contact',
            message: 'Site message'
        ));

        $user->notify(new StoryStarted(story: $story));

        $user->notify(new StoryEnded(story: $story));

        $user->notify(new PostPublished(post: $post));

        $user->notify(new AnnouncementPublished(announcement: Announcement::factory()->create()));

        $user->notify(new PendingCharacterApproved(character: $pendingCharacter));

        $user->notify(new PendingCharacterDenied(character: $pendingCharacter));

        $user->notify(new AccountCreated(user: $user, password: 'password'));

        $user->notify(new CharacterAuthorAddedToPost(post: $post, character: $activeCharacter));

        $user->notify(new CharacterAuthorRemovedFromPost(post: $post, character: $activeCharacter));

        $user->notify(new UserAuthorAddedToPost(post: $post));

        $user->notify(new UserAuthorRemovedFromPost(post: $post));

        $user->notify(new DraftPostDiscarded(post: $post, user: $activeUser));

        $user->notify(new PostSaved(post: $post, user: $activeUser));

        $user->notify(new ApplicationReadyForReview(application: $application));

        $review = $application->reviews()->firstOrFail()->pivot;

        $user->notify(new ApplicationReviewerVotedToAccept(
            application: $application,
            reviewer: $activeUser,
            review: $review,
        ));

        $user->notify(new ApplicationReviewerVotedToDeny(
            application: $application,
            reviewer: $activeUser,
            review: $review,
        ));

        $user->notify(new ApplicationAccepted(application: $application));

        $user->notify(new ApplicationDenied(application: $application));

        activity()->enableLogging();
    }
}
