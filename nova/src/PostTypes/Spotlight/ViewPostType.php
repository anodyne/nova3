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

class ViewPostType extends SpotlightCommand
{
    protected string $name = 'View Post Type';

    protected string $description = 'View a post type';

    protected array $synonyms = [
        'show a post type',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('postType')
                    ->setPlaceholder('Which post type do you want to view?')
            );
    }

    public function searchPostType($query)
    {
        return PostType::where('name', 'like', "%${query}%")
            ->get()
            ->map(function ($postType) {
                return new SpotlightSearchResult(
                    $postType->id,
                    $postType->name,
                    sprintf('View %s', $postType->name)
                );
            });
    }

    public function execute(Spotlight $spotlight, PostType $postType): void
    {
        $spotlight->redirectRoute('post-types.show', $postType);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('view', new PostType());
    }
}
