<?php

declare(strict_types=1);

namespace Nova\Pages\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Pages\Models\Page;
use Nova\Pages\Responses\PreviewBasicPageResponse;

class PreviewBasicPageController extends Controller
{
    public function __invoke(string $pageKey)
    {
        return PreviewBasicPageResponse::sendWith(
            data: [
                'page' => $page = Page::key($pageKey)->sole(),
            ],
            page: $page
        );
    }
}
