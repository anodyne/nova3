<?php

declare(strict_types=1);

namespace Nova\Foundation\Actions;

use Anodyne\TablerIcons\Tabler;
use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;

class RecacheIcons
{
    use AsAction;

    public function handle(): void
    {
        Cache::forget('tabler.icons.searchable');

        $searchableIcons = collect(Tabler::cases())
            ->map(fn ($icon) => [
                'name' => $name = str($icon->name)->headline()->toString(),
                'value' => $icon->value,
                'searchable' => strtolower($name.' '.$icon->value),
            ])
            ->values()
            ->toArray();

        Cache::put('tabler.icons.searchable', $searchableIcons);
    }
}
