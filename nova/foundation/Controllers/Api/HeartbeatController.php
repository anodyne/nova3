<?php

declare(strict_types=1);

namespace Nova\Foundation\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Nova\Setup\Telemetry;

class HeartbeatController
{
    public function __invoke(): JsonResponse
    {
        return response()->json((new Telemetry)->gatherSimpleHeartbeatData());
    }
}
