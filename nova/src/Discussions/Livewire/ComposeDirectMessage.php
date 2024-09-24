<?php

declare(strict_types=1);

namespace Nova\Discussions\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Nova\Discussions\Actions\StartDiscussion;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Data\DiscussionMessageData;
use Nova\Discussions\Data\DiscussionParticipantsData;
use Nova\Discussions\Enums\MessageType;
use Nova\Discussions\Exceptions\TooManyDirectMessageParticipants;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Users\Models\User;

class ComposeDirectMessage extends ModalComponent
{
    #[Validate('required')]
    public ?int $recipient;

    #[Validate('required')]
    public string $content;

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
                name: null,
                isDirectMessage: true,
                directMessageParticipants: [Auth::id(), $this->recipient],
                message: new DiscussionMessageData(
                    userId: Auth::id(),
                    content: $this->content,
                    type: MessageType::Text,
                ),
                participants: new DiscussionParticipantsData(
                    sender: Auth::id(),
                    recipients: [$this->recipient]
                )
            );

            StartDiscussion::run($data);

            $this->dismiss();

            $this->dispatch('discussion-started');

            Notification::make()->success()
                ->title('Direct message sent')
                ->send();
        } catch (TooManyDirectMessageParticipants $th) {
            Notification::make()->danger()
                ->title('Direct message could not be sent')
                ->body('Direct messages can only have 2 participants. Please try again.')
                ->send();
        } catch (\Throwable $th) {
            Notification::make()->danger()
                ->title('Direct message could not be sent')
                ->body('There was an error when trying to send your direct message. Please try again.')
                ->send();
        }
    }

    public function render()
    {
        return view('pages.discussions.livewire.compose-direct-message-modal', [
            'users' => $this->users,
        ]);
    }
}
