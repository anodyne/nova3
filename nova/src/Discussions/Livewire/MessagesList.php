<?php

declare(strict_types=1);

namespace Nova\Discussions\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public ?string $search = null;

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
        return Discussion::query()
            ->with([
                'participants',
                'notifications' => fn (HasMany $query): HasMany => $query->where('user_id', Auth::id()),
                'lastMessage.user',
            ])
            ->select([
                'discussable_id',
                'discussable_type',
                'id',
                'subject',
                'updated_at',
            ])
            ->conversation()
            ->forCurrentUser()
            ->when($this->filter === 'unread', function (Builder $query): Builder {
                return $query->whereHas('notifications', function (Builder $query): Builder {
                    return $query->where('user_id', Auth::id())->where('is_seen', 0);
                });
            })
            ->when(filled($this->search), fn (Builder $query): Builder => $query->searchFor($this->search))
            ->latest('updated_at')
            ->simplePaginate(15);
    }

    public function updatedFilter(string $value): void
    {
        $this->clearSelected();
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
