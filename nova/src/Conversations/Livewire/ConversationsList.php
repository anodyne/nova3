<?php

declare(strict_types=1);

namespace Nova\Conversations\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ConversationsList extends Component
{
    public ?int $selected = null;

    #[Computed]
    public function conversations(): Collection
    {
        return Auth::user()
            ->conversations()
            ->with('messages', 'recipients.media')
            ->latest()
            ->get();
    }

    public function newConversation(): void
    {
        Auth::user()->conversations()->create([]);
    }

    public function selectConversation($id): void
    {
        $this->selected = $id;

        $this->dispatch('conversation-selected', conversationId: $id);
    }

    public function mount()
    {
        $this->selectConversation($this->conversations->first()?->id);
    }

    public function render()
    {
        return view('pages.conversations.livewire.list', [
            'conversations' => $this->conversations,
        ]);
    }
}
