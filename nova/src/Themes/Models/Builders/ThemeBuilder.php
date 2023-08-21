<?php

declare(strict_types=1);

namespace Nova\Themes\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Themes\Enums\ThemeStatus;

class ThemeBuilder extends Builder
{
    public function active(): self
    {
        return $this->where('status', ThemeStatus::active);
    }

    public function inactive(): self
    {
        return $this->where('status', ThemeStatus::inactive);
    }

    public function location($location): self
    {
        return $this->where('location', $location);
    }
}
