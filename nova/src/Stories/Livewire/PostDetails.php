<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Actions\UpdatePost;
use Nova\Stories\Data\PostDetailsData;
use Nova\Stories\Models\Post;

class PostDetails extends Component
{
    use Concerns\InteractsWithPost;
    use Concerns\InteractsWithPostType;

    public ?string $title = null;

    public ?string $location = null;

    public ?string $day = null;

    public ?string $time = null;

    public ?string $content = null;

    public function updated($property, $value): void
    {
        if ($property === 'content') {
            return;
        }

        $this->dispatch('post-updated');

        $this->dispatch(
            'post-details-updated',
            title: $this->title,
            location: $this->location,
            day: $this->day,
            time: $this->time
        );
    }

    public function mount(Post $post): void
    {
        $this->postId = $post->id;
        $this->postTypeId = $post->post_type_id;
        $this->title = $post->title;
        $this->location = $post->location;
        $this->day = $post->day;
        $this->time = $post->time;
        $this->content = $post->content;
    }

    public function render(): View
    {
        return view('pages.posts.livewire.post-details', [
            'postType' => $this->getPostType(),
        ]);
    }

    #[On('save-post')]
    public function save(): void
    {
        try {
            $post = $this->getPost();

            UpdatePost::run($post, PostDetailsData::from(
                content: $this->content,
                day: $this->day,
                location: $this->location,
                time: $this->time,
                title: $this->title
            ));

            $this->dispatch('save-post-completed')->to(PostComposer::class);
        } catch (ModelNotFoundException $th) {
            Notification::make()->danger()
                ->title('Post details could not be saved')
                ->send();
        }
    }
}
