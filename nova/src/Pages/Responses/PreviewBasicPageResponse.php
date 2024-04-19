<?php

declare(strict_types=1);

namespace Nova\Pages\Responses;

use Nova\Foundation\Responses\Responsable;

class PreviewBasicPageResponse extends Responsable
{
    public string $view = 'pages.basic-page-preview';
}
