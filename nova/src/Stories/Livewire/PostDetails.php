<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Actions\UpdateContributorWordCount;
use Nova\Stories\Actions\UpdatePost;
use Nova\Stories\Data\PostDetailsData;
use Nova\Stories\Livewire\Concerns\InteractsWithPost;
use Nova\Stories\Livewire\Concerns\InteractsWithPostType;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

/**
 * @property-read Collection $availablePostTypes
 * @property-read ?PostType $postType
 */
class PostDetails extends Component
{
    use InteractsWithPost;
    use InteractsWithPostType;

    public ?string $title = null;

    public ?string $location = null;

    public ?string $day = null;

    public ?string $time = null;

    public ?string $content = null;

    public function updated($property, $value): void
    {
        if ($property === 'content' && blank(str($value)->pipe('strip_tags'))) {
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
            'postType' => $this->postType,
        ]);
    }

    #[On('save-post')]
    public function save(): void
    {
        try {
            $post = $this->getPost();

            $oldPostWordCount = $post->word_count;

            UpdatePost::run($post, PostDetailsData::from(
                content: filled(str($this->content)->pipe('strip_tags')) ? $this->content : null,
                day: $this->day,
                location: $this->location,
                time: $this->time,
                title: $this->title
            ));

            UpdateContributorWordCount::run(
                post: $post,
                user: Auth::user(),
                oldWordCount: $oldPostWordCount,
            );

            $this->dispatch('save-post-completed')->to(PostComposer::class);
        } catch (ModelNotFoundException) {
            Notification::make()->danger()
                ->title('Post details could not be saved')
                ->send();
        }
    }
}
