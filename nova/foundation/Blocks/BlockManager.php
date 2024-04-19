<?php

declare(strict_types=1);

namespace Nova\Foundation\Blocks;

use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Wrappers\Group;
use Illuminate\Support\Collection;

class BlockManager
{
    public function __construct(
        protected ?Collection $formBlocks = null,
        protected ?Collection $pageBlocks = null
    ) {
        $this->formBlocks = collect();
        $this->pageBlocks = collect();
    }

    public function blocks(): Collection
    {
        return $this->pageBlocks
            ->concat($this->formBlocks)
            ->flatten();
    }

    public function formBlocks(): Collection
    {
        return $this->formBlocks;
    }

    public function groupedFormBlocks(): array
    {
        $categories = [
            'hero' => 'Hero',
        ];

        return collect($categories)
            ->flatMap(function ($value, $key): array {
                return [Group::make($value)->tools($this->formBlocks($key)->toArray())];
            })
            ->toArray();
    }

    public function pageBlocks(?string $group): Collection
    {
        return $this->pageBlocks
            ->when($group, function (Collection $collection) use ($group) {
                return $collection->filter(
                    fn (ScribbleTool $block) => str($block->getIdentifier())->startsWith($group)
                );
            });
    }

    public function groupedPageBlocks(): array
    {
        $categories = [
            'hero' => 'Hero',
            'cta' => 'Call to action',
            'features' => 'Features',
            'stats' => 'Stats',
            'logos' => 'Logo clouds',
            'manifest' => 'Character manifest',
            'stories' => 'Stories',
            'ratings' => 'Content ratings',
            'content' => 'Freeform content',
        ];

        return collect($categories)
            ->flatMap(function ($value, $key): array {
                return [Group::make($value)->tools($this->pageBlocks($key)->toArray())];
            })
            ->toArray();
    }

    public function registerFormBlock(ScribbleTool $blockClass): self
    {
        $this->formBlocks->push($blockClass);

        return $this;
    }

    public function registerFormBlocks(array $blocks): self
    {
        $this->formBlocks = $this->formBlocks->merge($blocks);

        return $this;
    }

    public function registerPageBlock(ScribbleTool $blockClass): self
    {
        $this->pageBlocks->push($blockClass);

        return $this;
    }

    public function registerPageBlocks(array $blocks): self
    {
        $this->pageBlocks = $this->pageBlocks->merge($blocks);

        return $this;
    }
}
