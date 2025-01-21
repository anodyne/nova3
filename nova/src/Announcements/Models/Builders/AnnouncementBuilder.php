<?php

declare(strict_types=1);

namespace Nova\Announcements\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class AnnouncementBuilder extends Builder
{
    public function notPublished(): self
    {
        return $this->where('published', false);
    }

    public function published(): self
    {
        return $this->where('published', true);
    }

    public function searchFor($search): self
    {
        return $this->where('title', 'like', "%{$search}%");
    }

    public function uniqueCategories(): self
    {
        return $this->select('category')->distinct();
    }
}
