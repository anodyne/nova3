<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Actions\UpdatePostPosition;
use Nova\Stories\Data\PostPositionData;
use Nova\Stories\Enums\PositionDirection;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\PostStatus\Published;

#[On('save-post-completed')]
class PostPosition extends Component
{
    use Concerns\InteractsWithPost;

    public ?string $title = null;

    public ?string $location = null;

    public ?string $day = null;

    public ?string $time = null;

    public ?Post $previousPost = null;

    public ?Post $nextPost = null;

    public ?Post $neighbor = null;

    public PositionDirection $direction;

    public function getTitle(?Post $post = null): string
    {
        if (blank($post)) {
            return $this->title ?? 'This post';
        }

        return $post->title;
    }

    public function getLocationDayTime(?Post $post = null): string
    {
        $pieces = blank($post)
            ? [$this->location, $this->day, $this->time]
            : [$post->location, $post->day, $post->time];

        return collect($pieces)->filter()->join(', ');
    }

    public function openForEditing(): void
    {
        $this->dispatch(
            'slide-over.open',
            component: 'posts-position-editor',
            arguments: [
                'postId' => $this->postId,
                'nextId' => $this->nextPost?->id,
                'previousId' => $this->previousPost?->id,
            ]
        );
    }

    public function mount(Post $post): void
    {
        $this->postId = $post->id;

        $this->title = $post->title;
        $this->location = $post->location;
        $this->day = $post->day;
        $this->time = $post->time;
        $this->direction = PositionDirection::After;

        $this->previousPost = $post->previousSibling(Published::class);
        $this->nextPost = $post->nextSibling(Published::class);
    }

    public function render(): View
    {
        return view('pages.posts.livewire.post-position');
    }

    #[On('post-details-updated')]
    public function handlePostDetailsUpdate(?string $title, ?string $location, ?string $day, ?string $time): void
    {
        $this->title = $title;
        $this->location = $location;
        $this->day = $day;
        $this->time = $time;
    }

    #[On('save-post')]
    #[Renderless]
    public function save(): void
    {
        try {
            $post = $this->getPost();

            $positionChange = match (true) {
                filled($this->neighbor) && in_array($this->direction, [PositionDirection::After, PositionDirection::Before]) => true,
                blank($this->neighbor) && in_array($this->direction, [PositionDirection::End, PositionDirection::Start]) => true,
                default => false,
            };

            UpdatePostPosition::run($post, PostPositionData::from(
                neighbor: $this->neighbor,
                direction: $this->direction,
                hasPositionChange: $positionChange
            ));

            $this->dispatch('save-post-completed')->to(PostComposer::class);
        } catch (ModelNotFoundException $th) {
            Notification::make()->danger()
                ->title('Post position could not be saved')
                ->send();
        }
    }

    #[On('update-post-position')]
    public function handlePositionUpdates(?int $neighborId, PositionDirection $direction): void
    {
        $this->neighbor = Post::find($neighborId);
        $this->direction = $direction;

        if ($direction === PositionDirection::Before) {
            $this->nextPost = $this->neighbor;
            $this->previousPost = $this->neighbor->previousSibling(status: Published::class);
        } else {
            $this->previousPost = $this->neighbor;
            $this->nextPost = $this->neighbor->nextSibling(status: Published::class);
        }

        $this->dispatch('post-updated');
    }
}
