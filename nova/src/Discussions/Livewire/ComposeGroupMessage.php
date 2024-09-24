<?php

declare(strict_types=1);

namespace Nova\Discussions\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Nova\Discussions\Actions\SendSystemMessage;
use Nova\Discussions\Actions\StartDiscussion;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Data\DiscussionMessageData;
use Nova\Discussions\Data\DiscussionParticipantsData;
use Nova\Discussions\Enums\MessageType;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Users\Models\User;

class ComposeGroupMessage extends ModalComponent
{
    #[Validate('required')]
    public array $recipients = [];

    #[Validate('required')]
    public string $content;

    public ?string $name;

    public ?int $discussionId = null;

    #[Computed]
    public function discussion(): ?Discussion
    {
        return Discussion::find($this->discussionId);
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
                isDirectMessage: false,
                directMessageParticipants: null,
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

            StartDiscussion::run($data);

            $this->dismiss();

            $this->dispatch('discussion-started');

            Notification::make()->success()
                ->title('Group message sent')
                ->send();
        } catch (\Throwable $th) {
            Notification::make()->danger()
                ->title('Group message could not be sent')
                ->body('There was an error when trying to send your group message. Please try again.')
                ->send();
        }
    }

    public function update(): void
    {
        try {
            // $this->validate();

            $this->discussion->update([
                'name' => $this->name,
            ]);

            $changes = $this->discussion
                ->allParticipants()
                ->sync(collect($this->recipients)->merge([Auth::id()])->unique()->all());

            foreach ($changes['attached'] as $attached) {
                SendSystemMessage::run($this->discussion, new DiscussionMessageData(
                    userId: $attached,
                    content: User::find($attached)->name.' was added to the conversation by '.Auth::user()->name,
                    type: MessageType::System,
                ));
            }

            foreach ($changes['detached'] as $detached) {
                SendSystemMessage::run($this->discussion, new DiscussionMessageData(
                    userId: $detached,
                    content: User::find($detached)->name.' was removed from the conversation by '.Auth::user()->name,
                    type: MessageType::SystemDanger,
                ));
            }

            $this->dismiss();

            $this->dispatch('discussion-updated');

            Notification::make()->success()
                ->title('Group message settings updated')
                ->send();
        } catch (\Throwable $th) {
            Notification::make()->danger()
                ->title('Group message settings could not be updated')
                ->send();

            dump($th->getMessage());
        }
    }

    public function mount(): void
    {
        if (filled($this->discussionId)) {
            $this->name = $this->discussion->name;
            $this->recipients = $this->discussion->allParticipants->pluck('id')->all();
        }
    }

    public function render()
    {
        return view('pages.discussions.livewire.compose-group-message-modal', [
            'discussion' => $this->discussion,
            'users' => $this->users,
        ]);
    }
}
