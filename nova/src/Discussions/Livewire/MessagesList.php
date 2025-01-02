<?php

declare(strict_types=1);

namespace Nova\Discussions\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Discussions\Actions\MarkDiscussionRead;
use Nova\Discussions\Models\Discussion;

#[On('discussion-started')]
#[On('discussion-updated')]
#[On('discussion-removed')]
#[On('message-sent')]
class MessagesList extends Component
{
    use WithPagination;

    #[Locked]
    public ?int $selected = null;

    public string $filter = 'all';

    public $pageHeading = null;

    public $pageSubheading = null;

    public $pageIntro = null;

    #[Computed]
    public function selectedDiscussion(): ?Discussion
    {
        return Discussion::find($this->selected);
    }

    #[Computed]
    public function discussions(): Paginator
    {
        return Discussion::with('participants', 'notifications')
            ->conversation()
            ->forCurrentUser()
            ->when($this->filter === 'private', fn (Builder $query): Builder => $query->directMessage())
            ->when($this->filter === 'group', fn (Builder $query): Builder => $query->groupMessage())
            ->latest('updated_at')
            ->simplePaginate(15);
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

    public function render()
    {
        return view('pages.discussions.livewire.messages-list', [
            'discussions' => $this->discussions,
        ]);
    }
}
