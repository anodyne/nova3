<?php

namespace Nova\Posts\Livewire\Concerns;

use Nova\PostTypes\Models\PostType;

trait HasPostType
{
    public $allPostTypes;

    public $postType;

    public function setPostType($postTypeId = null)
    {
        $this->postType = PostType::find($postTypeId);

        $this->getSuggestedPost();
    }

    protected function setPostTypeIfOnlyOneIsAvailable()
    {
        if ($this->allPostTypes->count() === 1) {
            $this->postType = $this->allPostTypes->first();
        }
    }
}
