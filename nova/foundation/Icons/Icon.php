<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;

class Icon implements Htmlable
{
    protected IconSet $set;

    public function __construct(
        protected ?string $name = null,
        protected string $size = 'md',
        protected string $class = '',
        protected array $attributes = []
    ) {
        $this->set = app(IconSets::class)->getCurrentSet();
    }

    public function toHtml(): string
    {
        return svg(
            $this->name(),
            $this->class,
            $this->attributes
        )->toHtml();
    }

    public function make(string $name, string $size = 'md', string $class = '', array $attributes = []): self
    {
        $this->name = $name;
        $this->size = $size;
        $this->class = Arr::toCssClasses([
            $size,
            $class,
        ]);
        $this->attributes = $attributes;

        return $this;
    }

    public function name(): string
    {
        return $this->set->getIcon($this->name);

        return sprintf(
            '%s-%s',
            $this->set->prefix(),
            $this->set->getIcon($this->name)
        );
    }

    public function __toString()
    {
        return $this->name();
    }
}
