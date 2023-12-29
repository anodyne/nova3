<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Exception;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\EnvWriter;
use Nova\Settings\Data\General;
use Nova\Settings\Data\GeneralConfiguration;
use Nova\Settings\Models\Settings;

class UpdateGeneral
{
    use AsAction;

    public function handle(General $generalData, Request $request): Settings
    {
        $envWriter = app(EnvWriter::class);

        if ($envWriter->isEnvWritable()) {
            $generalConfigData = GeneralConfiguration::from($request);

            ray($request->all());
            ray($generalConfigData);

            $path = $envWriter->envFilePath();

            if (file_exists($path)) {
                $write = $envWriter->write(array_merge(
                    [
                        'APP_ENV' => $generalConfigData->environment,
                        'APP_DEBUG' => $generalConfigData->debugMode(),
                    ],
                ));

                if (! $write) {
                    throw new Exception('error');
                }
            }
        }

        return settings()->refresh();
    }
}
