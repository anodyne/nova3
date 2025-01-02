<?php

declare(strict_types=1);

namespace Nova\Discussions\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Nova\Discussions\Actions\DeleteDiscussion;
use Nova\Discussions\Actions\DeleteDiscussionMessage;
use Nova\Discussions\Actions\LeaveDiscussion;
use Nova\Discussions\Actions\SendMessage;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Data\DiscussionMessageData;
use Nova\Discussions\Data\DiscussionParticipantsData;
use Nova\Discussions\Enums\MessageType;
use Nova\Discussions\Exceptions\CannotLeaveDirectMessage;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Users\Models\User;

#[On('message-sent')]
class MessageHistory extends Component
{
    #[Reactive]
    public ?int $discussionId = null;

    public ?string $content = null;

    public bool $remainingMessagesLoaded = false;

    #[Computed]
    public function discussion(): ?Discussion
    {
        return Discussion::with('messages', 'participants', 'notifications')
            ->find($this->discussionId);
    }

    #[Computed]
    public function latestMessage(): ?DiscussionMessage
    {
        if (blank($this->discussion)) {
            return null;
        }

        return $this->discussion->messages->last();
    }

    #[Computed]
    public function remainingMessages(): ?Collection
    {
        if (blank($this->discussion)) {
            return null;
        }

        return $this->discussion->messages->slice(0, $this->discussion->messages->count() - 1);
    }

    #[Computed]
    public function messages(): Collection
    {
        if (blank($this->discussion)) {
            return Collection::make();
        }

        // return $this->discussion->messages->groupBy(function ($message) {
        //     return format_date($message->created_at, raw: true);
        // });

        return $this->discussion->messages;
    }

    #[Computed]
    public function participant(): ?User
    {
        return $this->discussion?->participants?->first();
    }

    public function deleteDiscussion(): void
    {
        $this->authorize('delete', $this->discussion);

        DeleteDiscussion::run($this->discussion);

        $this->dispatch('discussion-removed');

        Notification::make()->success()
            ->title('Conversation has been deleted')
            ->send();
    }

    public function deleteMessage(DiscussionMessage $message): void
    {
        $this->authorize('delete', $this->discussion);

        DeleteDiscussionMessage::run($message);

        Notification::make()->success()
            ->title('Message has been removed from the conversation')
            ->send();
    }

    public function leaveDiscussion(): void
    {
        $this->authorize('leave', $this->discussion);

        try {
            LeaveDiscussion::run($this->discussion);

            $this->dispatch('dropdown-close');

            $this->dispatch('discussion-removed');

            if ($this->discussion->is_direct_message) {
                Notification::make()->success()
                    ->title('You have deleted the direct message')
                    ->send();
            } else {
                Notification::make()->success()
                    ->title('You have left the group message')
                    ->send();
            }
        } catch (CannotLeaveDirectMessage $th) {
            Notification::make()->danger()
                ->title('Failed to leave discussion')
                ->body($th->getMessage())
                ->send();
        } catch (\Throwable $th) {
            Notification::make()->danger()
                ->title('Failed to leave discussion')
                ->send();
        }
    }

    public function sendMessage(): void
    {
        $this->authorize('view', $this->discussion);

        $data = new DiscussionData(
            name: $this->discussion->name,
            isDirectMessage: $this->discussion->is_direct_message,
            directMessageParticipants: $this->discussion->direct_message_participants,
            message: new DiscussionMessageData(
                userId: Auth::id(),
                content: $this->content,
                type: MessageType::Text
            ),
            participants: new DiscussionParticipantsData(
                sender: Auth::id(),
                recipients: $this->discussion->participants->pluck('id')->all()
            )
        );

        SendMessage::run($this->discussion, $data);

        $this->reset('content');

        $this->dispatch('message-sent');
    }

    public function render()
    {
        return view('pages.discussions.livewire.message-history', [
            'discussion' => $this->discussion,
            'latestMessage' => $this->latestMessage,
            'remainingMessages' => $this->remainingMessages,
        ]);
    }
}
