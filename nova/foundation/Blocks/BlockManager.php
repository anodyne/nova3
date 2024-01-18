<?php

declare(strict_types=1);

namespace Nova\Foundation\Blocks;

class BlockManager
{
    protected array $formBlocks = [];

    protected array $pageBlocks = [];

    public function blocks(): array
    {
        return array_merge(
            $this->pageBlocks,
            $this->formBlocks
        );
    }

    public function formBlocks(): array
    {
        return $this->formBlocks;
    }

    public function pageBlocks(): array
    {
        return $this->pageBlocks;
    }

    public function registerFormBlock(string $blockClass): self
    {
        $this->formBlocks[] = $blockClass;

        return $this;
    }

    public function registerFormBlocks(array $blocks): self
    {
        $this->formBlocks = array_merge($this->formBlocks, $blocks);

        return $this;
    }

    public function registerPageBlock(string $blockClass): self
    {
        $this->pageBlocks[] = $blockClass;

        return $this;
    }

    public function registerPageBlocks(array $blocks): self
    {
        $this->pageBlocks = array_merge($this->pageBlocks, $blocks);

        return $this;
    }
}
