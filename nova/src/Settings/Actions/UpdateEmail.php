<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Exception;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\EnvWriter;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\EmailConfiguration;
use Nova\Settings\Models\Settings;

class UpdateEmail
{
    use AsAction;

    public function handle(Email $emailData, EmailConfiguration $emailConfigData): Settings
    {
        $envWriter = app(EnvWriter::class);

        if ($envWriter->isEnvWritable()) {
            $path = $envWriter->envFilePath();

            if (file_exists($path)) {
                $write = $envWriter->set(array_merge(
                    [
                        'MAIL_MAILER' => $emailConfigData->mailer->value,
                        'MAIL_FROM_ADDRESS' => $emailConfigData->fromAddress,
                        'MAIL_FROM_NAME' => $emailConfigData->fromName,
                    ],
                    $emailConfigData->getEnvVariables(),
                ));

                if (! $write) {
                    throw new Exception('error');
                }
            }
        }

        return settings()->refresh();
    }
}
