<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Exception;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\EnvWriter;
use Nova\Settings\Data\EnvironmentConfiguration;

class UpdateEnvironment
{
    use AsAction;

    public function handle(Request $request): void
    {
        $envWriter = app(EnvWriter::class);

        if ($envWriter->isEnvWritable()) {
            $envConfigData = EnvironmentConfiguration::from($request);

            $path = $envWriter->envFilePath();

            if (file_exists($path)) {
                $write = $envWriter->write([
                    'APP_ENV' => $envConfigData->environment,
                    'APP_DEBUG' => $envConfigData->debugMode(),
                    'APP_URL' => $envConfigData->url,
                ]);

                if (! $write) {
                    throw new Exception('error');
                }
            }
        }
    }
}
