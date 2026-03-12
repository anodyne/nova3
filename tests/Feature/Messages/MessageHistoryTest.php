<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Discussions\Livewire\MessageHistory;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Discussions\Models\DiscussionNotification;
use Nova\Discussions\Models\DiscussionParticipant;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('messages');

beforeEach(function () {
    signIn();

    $this->user = User::factory()->active()->create();

    $this->discussion = Discussion::factory()->create(['subject' => 'Discussion']);
    $this->discussion->participants()->attach([Auth::id(), $this->user->id]);

    $this->discussionMessage1 = DiscussionMessage::factory()->text()->create([
        'discussion_id' => $this->discussion->id,
        'user_id' => Auth::id(),
    ]);
    $this->discussionMessage1->notifications()->createMany([
        ['discussion_id' => $this->discussion->id, 'user_id' => Auth::id(), 'is_seen' => true, 'is_sender' => true],
        ['discussion_id' => $this->discussion->id, 'user_id' => $this->user->id, 'is_seen' => false, 'is_sender' => false],
    ]);

    $this->discussionMessage2 = DiscussionMessage::factory()->text()->create([
        'discussion_id' => $this->discussion->id,
        'user_id' => $this->user->id,
    ]);
    $this->discussionMessage2->notifications()->createMany([
        ['discussion_id' => $this->discussion->id, 'user_id' => Auth::id(), 'is_seen' => false, 'is_sender' => false],
        ['discussion_id' => $this->discussion->id, 'user_id' => $this->user->id, 'is_seen' => true, 'is_sender' => true],
    ]);
});

test('can leave a discussion with more than 2 participants', function () {
    $user = User::factory()->create();

    $this->discussion->participants()->attach([$user->id]);

    livewire(MessageHistory::class, ['discussionId' => $this->discussion->id])
        ->call('leaveDiscussion')
        ->assertNotified()
        ->assertDispatched('discussion-removed');

    assertDatabaseMissing(DiscussionParticipant::class, [
        'discussion_id' => $this->discussion->id,
        'user_id' => Auth::id(),
    ]);
});

test('cannot leave a discussion with less than 3 participants', function () {
    livewire(MessageHistory::class, ['discussionId' => $this->discussion->id])
        ->call('leaveDiscussion')
        ->assertStatus(404)
        ->assertNotDispatched('discussion-removed');

    assertDatabaseHas(DiscussionParticipant::class, [
        'discussion_id' => $this->discussion->id,
        'user_id' => Auth::id(),
    ]);
});

test('can delete a discussion', function () {
    livewire(MessageHistory::class, ['discussionId' => $this->discussion->id])
        ->call('deleteDiscussion')
        ->assertNotified()
        ->assertDispatched('discussion-removed');

    assertDatabaseMissing(Discussion::class, [
        'id' => $this->discussion->id,
    ]);

    assertDatabaseMissing(DiscussionMessage::class, [
        'discussion_id' => $this->discussion->id,
    ]);

    assertDatabaseMissing(DiscussionParticipant::class, [
        'discussion_id' => $this->discussion->id,
    ]);

    assertDatabaseMissing(DiscussionNotification::class, [
        'discussion_id' => $this->discussion->id,
    ]);
});

test('can delete a message from a discussion', function () {
    livewire(MessageHistory::class, ['discussionId' => $this->discussion->id])
        ->call('deleteMessage', message: $this->discussionMessage1)
        ->assertNotified();

    assertDatabaseMissing(DiscussionMessage::class, [
        'id' => $this->discussionMessage1->id,
    ]);

    assertDatabaseMissing(DiscussionNotification::class, [
        'discussion_message_id' => $this->discussionMessage1->id,
    ]);
});

test('cannot delete a message from a discussion you are not a part of', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

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

    $discussionMessage2 = DiscussionMessage::factory()->text()->create([
        'discussion_id' => $discussion->id,
        'user_id' => $user2->id,
    ]);
    $discussionMessage2->notifications()->createMany([
        ['discussion_id' => $discussion->id, 'user_id' => $user1->id, 'is_seen' => false, 'is_sender' => false],
        ['discussion_id' => $discussion->id, 'user_id' => $user2->id, 'is_seen' => true, 'is_sender' => true],
    ]);

    livewire(MessageHistory::class, ['discussionId' => $discussion->id])
        ->call('deleteMessage', message: $discussionMessage1)
        ->assertStatus(404);

    assertDatabaseHas(DiscussionMessage::class, [
        'id' => $discussionMessage1->id,
    ]);
});

test('cannot delete a message from a discussion you are not a part of while viewing a discussion you are a part of', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

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

    $discussionMessage2 = DiscussionMessage::factory()->text()->create([
        'discussion_id' => $discussion->id,
        'user_id' => $user2->id,
    ]);
    $discussionMessage2->notifications()->createMany([
        ['discussion_id' => $discussion->id, 'user_id' => $user1->id, 'is_seen' => false, 'is_sender' => false],
        ['discussion_id' => $discussion->id, 'user_id' => $user2->id, 'is_seen' => true, 'is_sender' => true],
    ]);

    livewire(MessageHistory::class, ['discussionId' => $this->discussion->id])
        ->call('deleteMessage', message: $discussionMessage1)
        ->assertStatus(404);

    assertDatabaseHas(DiscussionMessage::class, [
        'id' => $discussionMessage1->id,
    ]);
});

describe('component initialized', function () {
    test('without a discussion ID', function () {
        livewire(MessageHistory::class)
            ->assertSet('discussionId', null)
            ->assertSet('discussion', null)
            ->assertSeeText('Select a conversation');
    });

    test('with a discussion ID', function () {
        livewire(MessageHistory::class, ['discussionId' => $this->discussion->id])
            ->assertSet('discussionId', $this->discussion->id)
            ->assertDontSeeText('Select a conversation')
            ->assertSeeText($this->discussionMessage2->content);
    });
});

describe('reacts to events', function () {
    test('discussion-selected resets load remaining messages flag', function () {
        livewire(MessageHistory::class)
            ->set('remainingMessagesLoaded', true)
            ->dispatch('discussion-selected')
            ->assertSet('remainingMessagesLoaded', false);
    });

    test('message-sent refreshes the component', function () {
        $history = livewire(MessageHistory::class, ['discussionId' => $this->discussion->id]);

        expect($history->latestMessage->id)->toBe($this->discussionMessage2->id);

        $message = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $this->discussion->id,
            'user_id' => Auth::id(),
        ]);
        $message->notifications()->createMany([
            ['discussion_id' => $this->discussion->id, 'user_id' => Auth::id(), 'is_seen' => true, 'is_sender' => true],
            ['discussion_id' => $this->discussion->id, 'user_id' => $this->user->id, 'is_seen' => false, 'is_sender' => false],
        ]);

        $history->dispatch('message-sent');

        expect($history->latestMessage->id)->toBe($message->id);
    });
});
