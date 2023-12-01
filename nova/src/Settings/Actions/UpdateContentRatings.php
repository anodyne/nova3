<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Settings\Data\ContentRating;
use Nova\Settings\Models\Settings;

class UpdateContentRatings
{
    use AsAction;

    public function handle(ContentRating $data, Request $request): Settings
    {
        return settings()->refresh();
    }
}
