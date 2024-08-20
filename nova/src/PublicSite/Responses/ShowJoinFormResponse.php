<?php

declare(strict_types=1);

namespace Nova\PublicSite\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowJoinFormResponse extends Responsable
{
    public string $view = 'public-site.join';
}
