<?php

declare(strict_types=1);

namespace Nova\Foundation\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Nova\Foundation\Models\Changelog;

class SyncExternalContentController
{
    public function __invoke(Request $request)
    {
        $this->syncExternalChangelog();

        $this->syncExternalContent();
    }

    protected function syncExternalChangelog(): void
    {
        $changelog = Http::get('https://anodyne-productions.com/api/external-changelog');

        if ($changelog->ok()) {
            foreach ($changelog as $version) {
                Changelog::updateOrCreate(
                    ['version' => $version['version']],
                    Arr::except($version, 'version')
                );
            }
        }
    }

    protected function syncExternalContent(): void
    {
        $content = Http::get('https://anodyne-productions.com/api/external-content');

        if ($content->ok()) {
        }
    }
}
