<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire;

use Nova\Posts\Livewire\Steps\ChoosePostTypeStep;
use Nova\Posts\Livewire\Steps\PublishPostStep;
use Nova\Posts\Livewire\Steps\WritePostStep;
use Nova\Posts\Models\Post;
use Spatie\LivewireWizard\Components\WizardComponent;

class WritePostWizard extends WizardComponent
{
    public function steps(): array
    {
        return [
            ChoosePostTypeStep::class,
            WritePostStep::class,
            PublishPostStep::class,
        ];
    }

    public function initialState(): ?array
    {
        $post = request()->route()->post;

        return [
            'posts:step:choose-post-type' => [
                // 'postType' => $post?->type,
                'postTypeId' => $post?->post_type_id,
            ],
            'posts:step:write-post' => [
                // 'post' => $post ?? new Post(),
                'postId' => $post?->id,
                'day' => $post?->day,
                'location' => $post?->location,
                'time' => $post?->time,
                'content' => $post?->content,
            ],
            'posts:step:publish-post' => [],
        ];
    }
}
