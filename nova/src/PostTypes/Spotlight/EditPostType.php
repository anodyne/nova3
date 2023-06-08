<?php

declare(strict_types=1);

namespace Nova\PostTypes\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\PostTypes\Models\PostType;

class EditPostType extends SpotlightCommand
{
    protected string $name = 'Edit Post Type';

    protected string $description = 'Edit a post type';

    protected array $synonyms = [
        'update existing post type',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('postType')
                    ->setPlaceholder('Which post type do you want to edit?')
            );
    }

    public function searchPostType($query)
    {
        return PostType::where('name', 'like', "%{$query}%")
            ->get()
            ->map(function ($postType) {
                return new SpotlightSearchResult(
                    $postType->id,
                    $postType->name,
                    sprintf('Edit %s', $postType->name)
                );
            });
    }

    public function execute(Spotlight $spotlight, PostType $postType): void
    {
        $spotlight->redirectRoute('post-types.edit', $postType);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', new PostType());
    }
}
