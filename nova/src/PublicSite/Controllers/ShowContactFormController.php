<?php

declare(strict_types=1);

namespace Nova\PublicSite\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\PublicSite\Responses\ShowContactFormResponse;

class ShowContactFormController extends Controller
{
    public function __invoke(): Responsable
    {
        return ShowContactFormResponse::send();
    }
}
