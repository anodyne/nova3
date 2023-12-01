<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Nova\Stories\Models\Post;

class PostForm extends Form
{
    public Post $post;

    #[Validate]
    public ?string $title = null;

    #[Validate]
    public ?string $content = null;

    #[Validate]
    public ?string $location = null;

    #[Validate]
    public ?string $day = null;

    #[Validate]
    public ?string $time = null;

    public int $rating_language = 0;

    public int $rating_sex = 0;

    public int $rating_violence = 0;

    #[Validate]
    public ?string $summary = null;

    public function save(): void
    {
        $this->post->update(array_merge(
            $this->all(),
            ['word_count' => str($this->content)->pipe('strip_tags')->wordCount()]
        ));
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;

        $this->title = $post->title;
        $this->content = $post->content;
        $this->location = $post->location;
        $this->day = $post->day;
        $this->time = $post->time;
        $this->rating_language = $post->rating_language ?? settings('ratings.language.rating');
        $this->rating_sex = $post->rating_sex ?? settings('ratings.sex.rating');
        $this->rating_violence = $post->rating_violence ?? settings('ratings.violence.rating');
        $this->summary = $post->summary;
    }

    public function rules()
    {
        return $this->post->postType->fields
            ->enabledFields()
            ->filter(fn ($item, $key) => in_array($key, ['title', 'location', 'day', 'time', 'content']))
            ->mapWithKeys(fn ($item, $key) => [$key => $item->required ? 'required' : 'nullable'])
            ->all();
    }
}
