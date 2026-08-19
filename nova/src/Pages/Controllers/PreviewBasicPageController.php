<?php

declare(strict_types=1);

namespace Nova\Pages\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Pages\Models\Page;
use Nova\Pages\Responses\PreviewBasicPageResponse;

class PreviewBasicPageController extends Controller
{
    public function __invoke(string $pageKey): Responsable
    {
        return PreviewBasicPageResponse::sendWith(
            data: [
                'page' => $page = Page::key($pageKey)->sole(),
            ],
            page: $page
        );
    }
}
