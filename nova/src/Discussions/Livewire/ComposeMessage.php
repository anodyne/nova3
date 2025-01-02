<?php

declare(strict_types=1);

namespace Nova\Discussions\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Nova\Discussions\Actions\SendMessage;
use Nova\Discussions\Actions\StartDiscussion;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Data\DiscussionMessageData;
use Nova\Discussions\Data\DiscussionParticipantsData;
use Nova\Discussions\Enums\ComposeMode;
use Nova\Discussions\Enums\MessageType;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Users\Models\User;
use Throwable;

class ComposeMessage extends ModalComponent
{
    #[Validate('required')]
    public array $recipients = [];

    #[Validate('required')]
    public string $content;

    public ?string $name = null;

    public ?int $discussionId = null;

    public ComposeMode $mode;

    #[Computed]
    public function discussion(): ?Discussion
    {
        return Discussion::find($this->discussionId);
    }

    #[Computed]
    public function isChangingName(): bool
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

    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    public function submit(): void
    {
        try {
            $this->validate();

            $data = new DiscussionData(
                name: $this->name,
                message: new DiscussionMessageData(
                    userId: Auth::id(),
                    content: $this->content,
                    type: MessageType::Text,
                ),
                participants: new DiscussionParticipantsData(
                    sender: Auth::id(),
                    recipients: $this->recipients
                )
            );

            $discussion = StartDiscussion::run($data);

            $this->dismiss();

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
        $this->validateOnly('content');

        $data = new DiscussionData(
            name: $this->name,
            message: new DiscussionMessageData(
                userId: Auth::id(),
                content: $this->content,
                type: MessageType::Text,
            ),
            participants: new DiscussionParticipantsData(
                sender: Auth::id(),
                recipients: $this->discussion->participants->pluck('id')->all()
            )
        );

        $this->dismiss();

        $this->dispatch('discussion-updated');

        SendMessage::run($this->discussion, $data);

        Notification::make()->success()
            ->title('Message reply sent')
            ->send();
    }

    public function updateName(): void
    {
        $this->validateOnly('name');

        $this->discussion->update([
            'name' => $this->name,
        ]);

        $this->dismiss();

        $this->dispatch('discussion-updated');

        Notification::make()->success()
            ->title('Group name was updated')
            ->send();
    }

    public function mount(): void
    {
        if (filled($this->discussionId)) {
            $this->name = $this->discussion->name;
        }
    }

    public function render()
    {
        return view('pages.discussions.livewire.compose-message-modal', [
            'discussion' => $this->discussion,
            'isChangingName' => $this->isChangingName,
            'isReplying' => $this->isReplying,
            'users' => $this->users,
        ]);
    }
}
