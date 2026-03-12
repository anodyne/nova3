<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Discussions\Actions\DeleteDiscussion;
use Nova\Discussions\Livewire\MessagesList;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Discussions\Models\DiscussionNotification;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;
use function Pest\Laravel\travel;
use function Pest\Livewire\livewire;

uses()->group('messages');

describe('authenticated user', function () {
    beforeEach(function () {
        signIn();

        $user1 = User::factory()->active()->create();
        $user2 = User::factory()->active()->create();

        $this->userDiscussion1 = Discussion::factory()->create(['subject' => 'User discussion 1']);
        $this->userDiscussion1->participants()->attach([Auth::id(), $user1->id]);

        $this->userDiscussionMessage1 = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $this->userDiscussion1->id,
            'user_id' => Auth::id(),
        ]);
        $this->userDiscussionMessage1->notifications()->createMany([
            ['discussion_id' => $this->userDiscussion1->id, 'user_id' => Auth::id(), 'is_seen' => true, 'is_sender' => true],
            ['discussion_id' => $this->userDiscussion1->id, 'user_id' => $user1->id, 'is_seen' => false, 'is_sender' => false],
        ]);

        $this->userDiscussionMessage2 = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $this->userDiscussion1->id,
            'user_id' => $user1->id,
        ]);
        $this->userDiscussionMessage2->notifications()->createMany([
            ['discussion_id' => $this->userDiscussion1->id, 'user_id' => Auth::id(), 'is_seen' => false, 'is_sender' => false],
            ['discussion_id' => $this->userDiscussion1->id, 'user_id' => $user1->id, 'is_seen' => true, 'is_sender' => true],
        ]);

        $this->userDiscussion2 = Discussion::factory()->create(['subject' => 'User discussion 2']);
        $this->userDiscussion2->participants()->attach([Auth::id(), $user1->id]);

        $this->userDiscussionMessage1 = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $this->userDiscussion2->id,
            'user_id' => Auth::id(),
        ]);
        $this->userDiscussionMessage1->notifications()->createMany([
            ['discussion_id' => $this->userDiscussion2->id, 'user_id' => Auth::id(), 'is_seen' => true, 'is_sender' => true],
            ['discussion_id' => $this->userDiscussion2->id, 'user_id' => $user1->id, 'is_seen' => true, 'is_sender' => false],
        ]);

        $this->userDiscussionMessage2 = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $this->userDiscussion2->id,
            'user_id' => $user1->id,
        ]);
        $this->userDiscussionMessage2->notifications()->createMany([
            ['discussion_id' => $this->userDiscussion2->id, 'user_id' => Auth::id(), 'is_seen' => true, 'is_sender' => false],
            ['discussion_id' => $this->userDiscussion2->id, 'user_id' => $user1->id, 'is_seen' => true, 'is_sender' => true],
        ]);

        $this->otherDiscussion = Discussion::factory()->create(['subject' => 'Other discussion']);
        $this->otherDiscussion->participants()->attach([$user1->id, $user2->id]);

        $this->otherDiscussionMessage1 = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $this->otherDiscussion->id,
            'user_id' => $user1->id,
        ]);
        $this->otherDiscussionMessage1->notifications()->createMany([
            ['discussion_id' => $this->otherDiscussion->id, 'user_id' => $user1->id, 'is_seen' => true, 'is_sender' => true],
            ['discussion_id' => $this->otherDiscussion->id, 'user_id' => $user2->id, 'is_seen' => false, 'is_sender' => false],
        ]);
        $this->otherDiscussionMessage2 = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $this->otherDiscussion->id,
            'user_id' => $user2->id,
        ]);
        $this->otherDiscussionMessage2->notifications()->createMany([
            ['discussion_id' => $this->otherDiscussion->id, 'user_id' => $user1->id, 'is_seen' => false, 'is_sender' => false],
            ['discussion_id' => $this->otherDiscussion->id, 'user_id' => $user2->id, 'is_seen' => true, 'is_sender' => true],
        ]);
    });

    test('can view the messages list', function () {
        get(route('admin.messages.index'))
            ->assertSuccessful();
    });

    test('can see message conversations they are part of', function () {
        livewire(MessagesList::class)
            ->assertCount('discussions', 2)
            ->assertSeeText('User discussion 1')
            ->assertSeeText('User discussion 2');
    });

    test('cannot see message conversations they are not part of', function () {
        livewire(MessagesList::class)
            ->assertCount('discussions', 2)
            ->assertDontSeeText('Other discussion');
    });

    test('can search messages by title', function () {
        livewire(MessagesList::class)
            ->set('search', 'foo')
            ->assertCount('discussions', 0)
            ->set('search', 'discussion')
            ->assertCount('discussions', 2)
            ->set('search', 'discussion 2')
            ->assertCount('discussions', 1)
            ->assertSeeText('User discussion 2')
            ->assertDontSeeText('User discussion 1');
    });

    test('can filter messages to only show unread messages', function () {
        livewire(MessagesList::class)
            ->set('filter', 'unread')
            ->assertCount('discussions', 1)
            ->assertSeeText('User discussion 1')
            ->assertDontSeeText('User discussion 2');
    });

    test('cannot see discussions associated with models', function () {
        $modelDiscussion = Discussion::factory()->create([
            'discussable_type' => 'application',
            'discussable_id' => 1,
            'subject' => 'Model discussion',
        ]);
        $modelDiscussion->participants()->attach([Auth::id()]);

        $modelDiscussionMessage1 = DiscussionMessage::factory()->text()->create([
            'discussion_id' => $modelDiscussion->id,
            'user_id' => Auth::id(),
        ]);
        $modelDiscussionMessage1->notifications()->createMany([
            ['discussion_id' => $modelDiscussion->id, 'user_id' => Auth::id(), 'is_seen' => true, 'is_sender' => true],
        ]);

        livewire(MessagesList::class)
            ->assertCount('discussions', 2)
            ->assertDontSeeText('Model discussion');
    });

    test('can select a discussion to view', function () {
        livewire(MessagesList::class)
            ->call('selectDiscussion', $this->userDiscussion1->id)
            ->assertSet('selected', $this->userDiscussion1->id)
            ->assertDispatched('discussion-selected');

        assertDatabaseMissing(DiscussionNotification::class, [
            'discussion_id' => $this->userDiscussion1->id,
            'user_id' => Auth::id(),
            'is_seen' => false,
        ]);
    });

    test('selecting a discussion to view marks it as read for the current user', function () {
        livewire(MessagesList::class)
            ->call('selectDiscussion', $this->userDiscussion1->id);

        assertDatabaseMissing(DiscussionNotification::class, [
            'discussion_id' => $this->userDiscussion1->id,
            'user_id' => Auth::id(),
            'is_seen' => false,
        ]);
    });

    describe('sets discussion from the URL', function () {
        test('can access discussion they are part of', function () {
            get(route('admin.messages.index', $this->userDiscussion1))
                ->assertSuccessful();
        });

        test('cannot access discussion they are not part of', function () {
            get(route('admin.messages.index', $this->otherDiscussion))
                ->assertNotFound();
        });
    });

    describe('reacts to events', function () {
        test('discussion-started selects the most recent discussion', function () {
            $list = livewire(MessagesList::class)
                ->assertCount('discussions', 2);

            $discussion = Discussion::factory()->create(['subject' => 'New user discussion']);
            $discussion->participants()->attach([Auth::id()]);

            $list->dispatch('discussion-started')
                ->assertCount('discussions', 3)
                ->assertSet('selected', $discussion->id);
        });

        test('discussion-updated sets the selected discussion to the updated discussion', function () {
            $list = livewire(MessagesList::class)
                ->assertSet('selected', null);

            // We want to simulate time passing before a reply is generated
            travel(10)->seconds();

            $this->userDiscussion1->messages()->create([
                'user_id' => Auth::id(),
                'content' => 'New message content',
                'type' => 'text',
            ]);

            $list->dispatch('discussion-updated')
                ->assertSet('selected', $this->userDiscussion1->id);
        });

        test('message-sent sets the selected discussion to the discussion the message was sent to', function () {
            $list = livewire(MessagesList::class)
                ->assertSet('selected', null);

            // We want to simulate time passing before a reply is generated
            travel(10)->seconds();

            $this->userDiscussion1->messages()->create([
                'user_id' => Auth::id(),
                'content' => 'New message content',
                'type' => 'text',
            ]);

            $list->dispatch('message-sent')
                ->assertSet('selected', $this->userDiscussion1->id);
        });

        test('discussion-removed clears the selected discussion', function () {
            $list = livewire(MessagesList::class)
                ->call('selectDiscussion', $this->userDiscussion2->id)
                ->assertSet('selected', $this->userDiscussion2->id);

            DeleteDiscussion::run($this->userDiscussion2);

            $list->dispatch('discussion-removed')
                ->assertSet('selected', null);
        });
    });
});

describe('unauthenticated user', function () {
    test('cannot view the messages list', function () {
        get(route('admin.messages.index'))
            ->assertRedirectToRoute('login');
    });
});
