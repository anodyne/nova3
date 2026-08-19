<?php

declare(strict_types=1);

namespace Nova\Discussions\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Nova\Discussions\Actions\SendMessage;
use Nova\Discussions\Actions\StartDiscussion;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Data\DiscussionMessageData;
use Nova\Discussions\Data\DiscussionParticipantsData;
use Nova\Discussions\Enums\ComposeMode;
use Nova\Discussions\Enums\MessageType;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\Modal;
use Nova\Users\Models\User;
use Throwable;

/**
 * @property-read ?Discussion $discussion
 * @property-read bool $isChangingSubject
 * @property-read bool $isReplying
 * @property-read Collection $users
 */
class ComposeMessage extends Modal
{
    #[Validate('required')]
    public array $recipients = [];

    #[Validate('required')]
    public string $content;

    public ?string $subject = null;

    public ?int $discussionId = null;

    public ComposeMode $mode;

    #[Computed]
    public function discussion(): ?Discussion
    {
        return Discussion::find($this->discussionId);
    }

    #[Computed]
    public function isChangingSubject(): bool
    {
        return filled($this->discussionId) && $this->mode === ComposeMode::ChangeGroupName;
    }

    #[Computed]
    public function isReplying(): bool
    {
        return filled($this->discussionId) && $this->mode === ComposeMode::Reply;
    }

    #[Computed]
    public function users(): Collection
    {
        return User::active()->where('id', '!=', Auth::id())->get();
    }

    public function submit(): void
    {
        try {
            $this->validate();

            $data = DiscussionData::from(
                subject: $this->subject,
                message: DiscussionMessageData::from(
                    userId: Auth::id(),
                    content: $this->content,
                    type: MessageType::Text,
                ),
                participants: DiscussionParticipantsData::from(
                    sender: Auth::id(),
                    recipients: $this->recipients
                )
            );

            $discussion = StartDiscussion::run($data);

            $this->close();

            $this->dispatch('discussion-started');

            Notification::make()->success()
                ->title($discussion->is_group_message ? 'Group message sent' : 'Private message sent')
                ->send();
        } catch (Throwable $th) {
            report($th);

            Notification::make()->danger()
                ->title('Message could not be sent')
                ->body('There was an error when trying to send your group message. Please try again.')
                ->send();
        }
    }

    public function reply(): void
    {
        $this->authorize('reply', $this->discussion);

        $this->validateOnly('content');

        $discussionData = DiscussionData::from(
            subject: $this->subject,
            message: DiscussionMessageData::from(
                userId: Auth::id(),
                content: $this->content,
                type: MessageType::Text,
            ),
            participants: DiscussionParticipantsData::from(
                sender: Auth::id(),
                recipients: $this->discussion->participants->pluck('id')->all()
            )
        );

        $this->close();

        $this->dispatch('discussion-updated');

        SendMessage::run($this->discussion, $discussionData);

        Notification::make()->success()
            ->title('Message reply sent')
            ->send();
    }

    public function updateSubject(): void
    {
        $this->authorize('update', $this->discussion);

        $this->validateOnly('subject');

        $this->discussion->update([
            'subject' => $this->subject,
        ]);

        $this->close();

        $this->dispatch('discussion-updated');

        Notification::make()->success()
            ->title('Subject was updated')
            ->send();
    }

    public function mount(): void
    {
        if (filled($this->discussionId)) {
            $this->subject = $this->discussion->subject;
        }
    }

    public function render(): Factory|View
    {
        return view('pages.discussions.livewire.compose-message-modal', [
            'discussion' => $this->discussion,
            'isChangingSubject' => $this->isChangingSubject,
            'isReplying' => $this->isReplying,
            'users' => $this->users,
        ]);
    }

    public static function size(): string
    {
        return '2xl';
    }
}
