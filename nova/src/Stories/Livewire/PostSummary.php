<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Actions\UpdatePost;
use Nova\Stories\Data\PostSummaryData;
use Nova\Stories\Livewire\Concerns\InteractsWithPost;
use Nova\Stories\Models\Post;

class PostSummary extends Component
{
    use InteractsWithPost;

    public ?string $summary = null;

    public function openForEditing(): void
    {
        $this->dispatch(
            'modal-open',
            modal: 'posts-summary-editor',
            props: ['summary' => $this->summary]
        );
    }

    public function mount(Post $post): void
    {
        $this->postId = $post->id;
        $this->summary = $post->summary;
    }

    public function render(): View
    {
        return view('pages.posts.livewire.post-summary');
    }

    #[On('save-post')]
    public function save(): void
    {
        try {
            $post = $this->getPost();

            UpdatePost::run($post, PostSummaryData::from(
                summary: $this->summary,
            ));

            $this->dispatch('save-post-completed')->to(PostComposer::class);
        } catch (ModelNotFoundException $th) {
            Notification::make()->danger()
                ->title('Post summary could not be saved')
                ->send();
        }
    }

    #[On('update-post-summary')]
    public function handleSummaryUpdate(?string $summary): void
    {
        $this->summary = $summary;

        $this->dispatch('post-updated');
    }
}
