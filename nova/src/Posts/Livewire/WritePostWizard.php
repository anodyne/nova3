<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire;

use Nova\Posts\Livewire\Steps\ChoosePostTypeStep;
use Nova\Posts\Livewire\Steps\PublishPostStep;
use Nova\Posts\Livewire\Steps\SelectAuthorsStep;
use Nova\Posts\Livewire\Steps\SetupPostStep;
use Nova\Posts\Livewire\Steps\WritePostStep;
use Nova\Posts\Models\Post;
use Spatie\LivewireWizard\Components\WizardComponent;

class WritePostWizard extends WizardComponent
{
    public function steps(): array
    {
        return [
            SetupPostStep::class,
            SelectAuthorsStep::class,
            WritePostStep::class,
            PublishPostStep::class,
        ];
    }

    public function initialState(): ?array
    {
        $post = request()->route()->post;

        return [
            'posts:step:setup-post' => [
                'postId' => $post?->id,
                'postTypeId' => $post?->post_type_id,
                'storyId' => $post?->story_id,
            ],
            'posts:step:select-authors' => [
                'postId' => $post?->id,
            ],
            'posts:step:write-post' => [
                'postId' => $post?->id,
                'storyId' => $post?->story_id,
                'ratingLanguage' => $post?->rating_language ?? settings()->ratings->language->rating,
                'ratingSex' => $post?->rating_sex ?? settings()->ratings->sex->rating,
                'ratingViolence' => $post?->rating_violence ?? settings()->ratings->violence->rating,
            ],
        ];
    }
}
