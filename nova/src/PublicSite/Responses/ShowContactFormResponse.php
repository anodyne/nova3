<?php

declare(strict_types=1);

namespace Nova\PublicSite\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowContactFormResponse extends Responsable
{
    public string $view = 'public-site.contact';
}
