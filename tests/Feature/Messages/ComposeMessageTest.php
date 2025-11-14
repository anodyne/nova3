<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Discussions\Enums\ComposeMode;
use Nova\Discussions\Livewire\ComposeMessage;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Discussions\Models\DiscussionNotification;
use Nova\Discussions\Models\DiscussionParticipant;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('messages');

beforeEach(fn() => signIn());

describe('creating discussion', function () {
    test('can create a new private discussion', function () {
        $user = createUser();

        livewire(ComposeMessage::class, ['mode' => ComposeMode::New])
            ->set('subject', 'New private message')
            ->set('content', 'Content of my private message')
            ->set('recipients', [$user->id])
            ->assertSet('subject', 'New private message')
            ->assertSet('content', 'Content of my private message')
            ->assertSet('recipients', [$user->id])
            ->call('submit')
            ->assertNotified()
            ->assertDispatched('discussion-started');

        $discussion = Discussion::latest('id')->first();

        assertDatabaseHas(Discussion::class, [
            'id' => $discussion->id,
            'subject' => 'New private message'
        ]);

        assertDatabaseHas(DiscussionMessage::class, [
            'discussion_id' => $discussion->id,
        ]);

        foreach ([$user, Auth::user()] as $participant) {
            assertDatabaseHas(DiscussionParticipant::class, [
                'discussion_id' => $discussion->id,
                'user_id' => $participant->id,
            ]);

            assertDatabaseHas(DiscussionNotification::class, [
                'discussion_id' => $discussion->id,
                'user_id' => $participant->id,
            ]);
        }
    });

    test('can create a new group discussion', function () {
        $user1 = createUser();
        $user2 = createUser();

        livewire(ComposeMessage::class, ['mode' => ComposeMode::New])
            ->set('subject', 'New group message')
            ->set('content', 'Content of my group message')
            ->set('recipients', [$user1->id, $user2->id])
            ->assertSet('subject', 'New group message')
            ->assertSet('content', 'Content of my group message')
            ->assertSet('recipients', [$user1->id, $user2->id])
            ->call('submit')
            ->assertNotified()
            ->assertDispatched('discussion-started');

        $discussion = Discussion::latest('id')->first();

        assertDatabaseHas(Discussion::class, [
            'id' => $discussion->id,
            'subject' => 'New group message'
        ]);

        assertDatabaseHas(DiscussionMessage::class, [
            'discussion_id' => $discussion->id,
        ]);

        foreach ([$user1, $user2, Auth::user()] as $participant) {
            assertDatabaseHas(DiscussionParticipant::class, [
                'discussion_id' => $discussion->id,
                'user_id' => $participant->id,
            ]);

            assertDatabaseHas(DiscussionNotification::class, [
                'discussion_id' => $discussion->id,
                'user_id' => $participant->id,
            ]);
        }
    });
});

describe('replying to discussion', function () {
    test('can reply to a discussion you are part of', function () {
        $user = createUser();

        $discussion = Discussion::factory()->create(['subject' => 'Discussion']);
        $discussion->participants()->attach([Auth::id(), $user->id]);

        $discussionMessage1 = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $discussion->id,
            'user_id' => Auth::id(),
        ]);
        $discussionMessage1->notifications()->createMany([
            ['discussion_id' => $discussion->id, 'user_id' => Auth::id(), 'is_seen' => true, 'is_sender' => true],
            ['discussion_id' => $discussion->id, 'user_id' => $user->id, 'is_seen' => false, 'is_sender' => false],
        ]);

        livewire(ComposeMessage::class, ['mode' => ComposeMode::Reply, 'discussionId' => $discussion->id])
            ->set('content', 'Replying to the message')
            ->assertSet('content', 'Replying to the message')
            ->call('reply')
            ->assertNotified()
            ->assertDispatched('discussion-updated');

        $message = DiscussionMessage::latest('id')->first();

        assertDatabaseHas(DiscussionMessage::class, [
            'discussion_id' => $discussion->id,
            'content' => 'Replying to the message',
        ]);

        foreach ([$user, Auth::user()] as $participant) {
            assertDatabaseHas(DiscussionNotification::class, [
                'discussion_id' => $discussion->id,
                'discussion_message_id' => $message->id,
                'user_id' => $participant->id,
            ]);
        }
    });

    test('cannot reply to a discussion you are not part of', function () {
        $user1 = createUser();
        $user2 = createUser();

        $discussion = Discussion::factory()->create(['subject' => 'Discussion']);
        $discussion->participants()->attach([$user1->id, $user2->id]);

        $discussionMessage1 = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $discussion->id,
            'user_id' => $user1->id,
        ]);
        $discussionMessage1->notifications()->createMany([
            ['discussion_id' => $discussion->id, 'user_id' => $user1->id, 'is_seen' => true, 'is_sender' => true],
            ['discussion_id' => $discussion->id, 'user_id' => $user2->id, 'is_seen' => false, 'is_sender' => false],
        ]);

        livewire(ComposeMessage::class, ['mode' => ComposeMode::Reply, 'discussionId' => $discussion->id])
            ->set('content', 'Replying to the message')
            ->assertSet('content', 'Replying to the message')
            ->call('reply')
            ->assertStatus(404);

        assertDatabaseMissing(DiscussionMessage::class, [
            'discussion_id' => $discussion->id,
            'content' => 'Replying to the message',
        ]);
    });
});

describe('changing discussion subject line', function () {
    test('can change a discussion you are part of', function () {
        $user = createUser();

        $discussion = Discussion::factory()->create(['subject' => 'Discussion']);
        $discussion->participants()->attach([Auth::id(), $user->id]);

        $discussionMessage1 = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $discussion->id,
            'user_id' => Auth::id(),
        ]);
        $discussionMessage1->notifications()->createMany([
            ['discussion_id' => $discussion->id, 'user_id' => Auth::id(), 'is_seen' => true, 'is_sender' => true],
            ['discussion_id' => $discussion->id, 'user_id' => $user->id, 'is_seen' => false, 'is_sender' => false],
        ]);

        livewire(ComposeMessage::class, ['mode' => ComposeMode::ChangeGroupName, 'discussionId' => $discussion->id])
            ->set('subject', 'New subject line')
            ->assertSet('subject', 'New subject line')
            ->call('updateSubject')
            ->assertNotified()
            ->assertDispatched('discussion-updated');

        assertDatabaseHas(Discussion::class, [
            'id' => $discussion->id,
            'subject' => 'New subject line',
        ]);
    });

    test('cannot change a discussion you are not part of', function () {
        $user1 = createUser();
        $user2 = createUser();

        $discussion = Discussion::factory()->create(['subject' => 'Discussion']);
        $discussion->participants()->attach([$user1->id, $user2->id]);

        $discussionMessage1 = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $discussion->id,
            'user_id' => $user1->id,
        ]);
        $discussionMessage1->notifications()->createMany([
            ['discussion_id' => $discussion->id, 'user_id' => $user1->id, 'is_seen' => true, 'is_sender' => true],
            ['discussion_id' => $discussion->id, 'user_id' => $user2->id, 'is_seen' => false, 'is_sender' => false],
        ]);

        livewire(ComposeMessage::class, ['mode' => ComposeMode::ChangeGroupName, 'discussionId' => $discussion->id])
            ->set('subject', 'New subject line')
            ->assertSet('subject', 'New subject line')
            ->call('updateSubject')
            ->assertStatus(404);

        assertDatabaseMissing(Discussion::class, [
            'id' => $discussion->id,
            'subject' => 'New subject line',
        ]);
    });
});

describe('component initialized', function () {
    test('without a discussion ID', function () {
        livewire(ComposeMessage::class, ['mode' => ComposeMode::New])
            ->assertSet('discussionId', null)
            ->assertSet('discussion', null);
    });

    test('with a discussion ID', function () {
        $user = createUser();

        $discussion = Discussion::factory()->create(['subject' => 'Discussion']);
        $discussion->participants()->attach([$user->id, Auth::id()]);

        $discussionMessage1 = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $discussion->id,
            'user_id' => $user->id,
        ]);
        $discussionMessage1->notifications()->createMany([
            ['discussion_id' => $discussion->id, 'user_id' => $user->id, 'is_seen' => true, 'is_sender' => true],
            ['discussion_id' => $discussion->id, 'user_id' => Auth::id(), 'is_seen' => false, 'is_sender' => false],
        ]);

        livewire(ComposeMessage::class, ['mode' => ComposeMode::Reply, 'discussionId' => $discussion->id])
            ->assertSet('discussionId', $discussion->id)
            ->assertDontSeeText('Select a conversation');
    });
});
