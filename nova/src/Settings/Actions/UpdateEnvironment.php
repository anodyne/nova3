<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Exception;
use Nova\Foundation\Actions\Action;
use Nova\Foundation\EnvWriter;
use Nova\Settings\Data\EnvironmentConfiguration;

class UpdateEnvironment extends Action
{
    public function handle(EnvironmentConfiguration $data): void
    {
        $envWriter = app(EnvWriter::class);

        if ($envWriter->isEnvWritable()) {
            $path = $envWriter->envFilePath();

            if (file_exists($path)) {
                $write = $envWriter->set([
                    'APP_ENV' => $data->environment->value,
                    'APP_DEBUG' => $data->debugMode,
                    'APP_URL' => $data->url,
                ]);

                if (! $write) {
                    throw new Exception('error');
                }
            }
        }
    }
}
