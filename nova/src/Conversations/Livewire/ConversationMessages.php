<?php

declare(strict_types=1);

namespace Nova\Conversations\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Nova\Conversations\Models\Conversation;
use Nova\Users\Models\User;

class ConversationMessages extends Component
{
    #[Reactive]
    public ?int $conversationId = null;

    public ?string $content = null;

    #[Computed]
    public function conversation(): ?Conversation
    {
        return Conversation::with('messages.author', 'recipients')->find($this->conversationId);
    }

    #[Computed]
    public function messages(): Collection
    {
        if (blank($this->conversation)) {
            return Collection::make();
        }

        return $this->conversation->messages;
    }

    #[Computed]
    public function recipient(): ?User
    {
        return $this->conversation?->recipients?->first();
    }

    public function sendMessage(): void
    {
        $this->conversation->messages()->create([
            'user_id' => auth()->id(),
            'content' => $this->content,
        ]);

        $this->content = null;
    }

    public function render()
    {
        return view('pages.conversations.livewire.messages', [
            'conversation' => $this->conversation,
            'messages' => $this->messages,
            'recipient' => $this->recipient,
            'me' => auth()->user(),
        ]);
    }
}
