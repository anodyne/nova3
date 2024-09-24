<?php

declare(strict_types=1);

namespace Nova\Discussions\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Discussions\Actions\MarkDiscussionRead;
use Nova\Discussions\Models\Discussion;
use Nova\Users\Models\User;

#[On('discussion-started')]
#[On('discussion-updated')]
#[On('discussion-removed')]
#[On('message-sent')]
class MessagesList extends Component
{
    #[Locked]
    public ?int $selected = null;

    public string $filter = 'all';

    #[Computed]
    public function selectedDiscussion(): ?Discussion
    {
        return Discussion::find($this->selected);
    }

    #[Computed]
    public function discussions(): Collection
    {
        return Discussion::with('messages', 'participants', 'notifications', 'lastMessage')
            ->conversation()
            // ->withoutCurrentUser()
            ->forCurrentUser()
            ->when($this->filter === 'private', fn (Builder $query): Builder => $query->directMessage())
            ->when($this->filter === 'group', fn (Builder $query): Builder => $query->groupMessage())
            ->latest('updated_at')
            ->get();
    }

    #[Computed]
    public function users(): Collection
    {
        return User::query()
            ->active()
            ->where('id', '!=', Auth::id())
            ->get();
    }

    public function changeFilter(string $value): void
    {
        $this->reset('selected');

        $this->filter = $value;
    }

    public function clearSelected(): void
    {
        $this->reset('selected');
    }

    public function selectDiscussion($id): void
    {
        $this->selected = $id;

        $this->authorize('view', $this->selectedDiscussion);

        $this->dispatch('discussion-selected', discussionId: $id);

        MarkDiscussionRead::run(
            discussion: $this->selectedDiscussion,
            user: Auth::user()
        );
    }

    #[On('discussion-removed')]
    public function clearSelectedDiscussion(): void
    {
        $this->selected = null;
    }

    #[On('discussion-started')]
    #[On('discussion-updated')]
    #[On('message-sent')]
    public function selectedLatestDiscussion(): void
    {
        $this->selectDiscussion($this->discussions->first()?->id);
    }

    public function mount()
    {
        // if (filled($this->selected)) {
        //     $this->selectDiscussion($discussion->id);
        // }

        // $this->selectedLatestDiscussion();
    }

    public function render()
    {
        return view('pages.discussions.livewire.messages-list', [
            'discussions' => $this->discussions,
            'users' => $this->users,
        ]);
    }
}
