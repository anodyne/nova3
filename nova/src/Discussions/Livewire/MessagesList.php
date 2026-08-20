<?php

declare(strict_types=1);

namespace Nova\Discussions\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Discussions\Actions\MarkDiscussionRead;
use Nova\Discussions\Models\Builders\DiscussionBuilder;
use Nova\Discussions\Models\Discussion;

/**
 * @property-read ?Discussion $selectedDiscussion
 * @property-read Paginator $discussions
 */
#[On('discussion-started')]
#[On('discussion-updated')]
#[On('discussion-removed')]
#[On('message-sent')]
class MessagesList extends Component
{
    use WithPagination;

    public string $filter = 'all';

    public $pageHeading;

    public $pageIntro;

    public $pageSubheading;

    public ?string $search = null;

    #[Locked]
    public ?int $selected = null;

    public function clearSelected(): void
    {
        $this->reset('selected');
    }

    #[On('discussion-removed')]
    public function clearSelectedDiscussion(): void
    {
        $this->selected = null;
    }

    #[Computed]
    public function discussions(): Paginator
    {
        return Discussion::conversation()
            ->with([
                'participants',
                'notifications' => function (Relation $query): void {
                    $query->where('user_id', Auth::id());
                },
                'lastMessage.user',
            ])
            ->select([
                'discussable_id',
                'discussable_type',
                'id',
                'subject',
                'updated_at',
            ])
            ->forCurrentUser()
            ->when($this->filter === 'unread', fn (Builder $query): Builder => $query->whereHas('notifications', fn (Builder $query): Builder => $query->where('user_id', Auth::id())->where('is_seen', 0)))
            ->when(filled($this->search), fn (DiscussionBuilder $query): DiscussionBuilder => $query->searchFor($this->search ?? ''))
            ->latest('updated_at')
            ->latest('id')
            ->simplePaginate(15);
    }

    public function render(): Factory|View
    {
        return view('pages.discussions.livewire.messages-list', [
            'discussions' => $this->discussions,
        ]);
    }

    public function selectDiscussion(?int $id): void
    {
        $this->selected = $id;

        $this->authorize('view', $this->selectedDiscussion);

        $this->dispatch('discussion-selected', discussionId: $id);

        MarkDiscussionRead::run(
            discussion: $this->selectedDiscussion,
            user: Auth::user()
        );
    }

    #[Computed]
    public function selectedDiscussion(): ?Discussion
    {
        return Discussion::find($this->selected);
    }

    #[On('discussion-started')]
    #[On('discussion-updated')]
    #[On('message-sent')]
    public function selectedLatestDiscussion(): void
    {
        $this->selectDiscussion($this->discussions->first()?->id);
    }

    public function updatedFilter(string $value): void
    {
        $this->clearSelected();
    }
}
