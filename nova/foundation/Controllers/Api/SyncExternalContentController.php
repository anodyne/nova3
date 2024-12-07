<?php

declare(strict_types=1);

namespace Nova\Foundation\Controllers\Api;

use Nova\Foundation\Models\ExternalChangelog;
use Nova\Foundation\Models\ExternalContent;

class SyncExternalContentController
{
    public function __invoke()
    {
        $this->syncExternalChangelog();

        $this->syncExternalContent();
    }

    protected function syncExternalChangelog(): void
    {
        ExternalChangelog::syncFromAnodyne();
    }

    protected function syncExternalContent(): void
    {
        ExternalContent::syncFromAnodyne();
    }
}
