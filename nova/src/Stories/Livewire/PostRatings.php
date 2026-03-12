<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Actions\UpdatePost;
use Nova\Stories\Data\PostRatingsData;
use Nova\Stories\Enums\ContentRatingValue;
use Nova\Stories\Livewire\Concerns\InteractsWithPost;
use Nova\Stories\Models\Post;

class PostRatings extends Component
{
    use InteractsWithPost;

    public ContentRatingValue $language;

    public ContentRatingValue $sex;

    public ContentRatingValue $violence;

    public function openForEditing(): void
    {
        $this->dispatch(
            'slide-over.open',
            component: 'posts-ratings-editor',
            arguments: [
                'language' => $this->language,
                'sex' => $this->sex,
                'violence' => $this->violence,
            ]
        );
    }

    public function mount(Post $post): void
    {
        $this->postId = $post->id;
        $this->language = $post->rating_language;
        $this->sex = $post->rating_sex;
        $this->violence = $post->rating_violence;
    }

    public function render(): View
    {
        return view('pages.posts.livewire.post-ratings');
    }

    #[On('save-post')]
    public function save(): void
    {
        try {
            $post = $this->getPost();

            UpdatePost::run($post, PostRatingsData::from(
                rating_language: $this->language,
                rating_sex: $this->sex,
                rating_violence: $this->violence
            ));

            $this->dispatch('save-post-completed')->to(PostComposer::class);
        } catch (ModelNotFoundException $th) {
            Notification::make()->danger()
                ->title('Post ratings could not be saved')
                ->send();
        }
    }

    #[On('save-post-ratings')]
    public function handleRatingsUpdate(ContentRatingValue $language, ContentRatingValue $sex, ContentRatingValue $violence): void
    {
        $this->language = $language;
        $this->sex = $sex;
        $this->violence = $violence;

        $this->dispatch('post-updated');
    }
}
