<?php

declare(strict_types=1);

namespace Nova\PublicSite\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowCharacterBioResponse extends Responsable
{
    public string $view = 'public-site.character-bio';
}
