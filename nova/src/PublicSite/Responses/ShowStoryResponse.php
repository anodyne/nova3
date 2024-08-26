<?php

declare(strict_types=1);

namespace Nova\PublicSite\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowStoryResponse extends Responsable
{
    public string $view = 'public-site.story-details';
}
