<?php

declare(strict_types=1);

namespace Nova\Discussions\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Nova\Discussions\Actions\DeleteDiscussion;
use Nova\Discussions\Actions\DeleteDiscussionMessage;
use Nova\Discussions\Actions\LeaveDiscussion;
use Nova\Discussions\Exceptions\CannotLeaveDirectMessage;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Users\Models\User;
use Throwable;

/**
 * @property-read ?Discussion $discussion
 * @property-read ?DiscussionMessage $latestMessage
 * @property-read ?Collection $remainingMessages
 * @property-read ?User $participant
 */
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
        if (is_null($this->discussionId)) {
            return null;
        }

        return once(function (): Discussion {
            return Discussion::query()
                ->with([
                    'messages',
                    'participants',
                    'notifications' => function (Relation $query): void {
                        $query->where('user_id', Auth::id());
                    },
                ])
                ->find($this->discussionId);
        });
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
        $this->authorize('deleteMessage', [$this->discussion, $message]);

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
            report($th);

            Notification::make()->danger()
                ->title('Failed to leave discussion')
                ->body($th->getMessage())
                ->send();
        } catch (Throwable $th) {
            report($th);

            Notification::make()->danger()
                ->title('Failed to leave discussion')
                ->send();
        }
    }

    #[On('discussion-selected')]
    public function resetMessageHistory(): void
    {
        $this->remainingMessagesLoaded = false;
    }

    public function render(): Factory|View
    {
        return view('pages.discussions.livewire.message-history', [
            'discussion' => $this->discussion,
            'latestMessage' => $this->latestMessage,
            'remainingMessages' => $this->remainingMessages,
        ]);
    }
}
