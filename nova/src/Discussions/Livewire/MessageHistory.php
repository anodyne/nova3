<?php

declare(strict_types=1);

namespace Nova\Discussions\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Nova\Discussions\Actions\LeaveDiscussion;
use Nova\Discussions\Actions\SendMessage;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Data\DiscussionMessageData;
use Nova\Discussions\Data\DiscussionParticipantsData;
use Nova\Discussions\Enums\MessageType;
use Nova\Discussions\Exceptions\CannotLeaveDirectMessage;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Users\Models\User;

#[On('message-sent')]
class MessageHistory extends Component
{
    #[Reactive]
    public ?int $discussionId = null;

    public ?string $content = null;

    #[Computed]
    public function discussion(): ?Discussion
    {
        return Discussion::with('messages', 'participants', 'notifications')
            ->find($this->discussionId);
    }

    #[Computed]
    public function messages(): Collection
    {
        if (blank($this->discussion)) {
            return Collection::make();
        }

        return $this->discussion->messages->groupBy(function ($message) {
            return format_date($message->created_at, raw: true);
        });

        return $this->discussion->messages;
    }

    #[Computed]
    public function participant(): ?User
    {
        return $this->discussion?->participants?->first();
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
            'messages' => $this->messages,
            'participant' => $this->participant,
            'me' => Auth::user(),
        ]);
    }
}
