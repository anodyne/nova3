<?php

declare(strict_types=1);

namespace Nova\Conversations\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;
use Nova\Conversations\Models\Conversation;

class ConversationComposer extends Component
{
    #[Reactive]
    public ?Conversation $conversation = null;

    public ?string $content = null;

    public function sendMessage(): void
    {
        $this->conversation->messages()->create([
            'user_id' => auth()->id(),
            'content' => $this->content,
        ]);

        $this->content = null;

        $this->dispatch('message-sent')->to(ConversationMessages::class);
    }

    public function render()
    {
        return view('pages.conversations.livewire.composer');
    }
}
