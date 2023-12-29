<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Exception;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\EnvWriter;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\EmailConfiguration;
use Nova\Settings\Models\Settings;

class UpdateEmail
{
    use AsAction;

    public function handle(Email $emailData, Request $request): Settings
    {
        $envWriter = app(EnvWriter::class);

        if ($envWriter->isEnvWritable()) {
            $emailConfigData = EmailConfiguration::from($request);

            $path = $envWriter->envFilePath();

            if (file_exists($path)) {
                $write = $envWriter->write(array_merge(
                    [
                        'MAIL_MAILER' => $emailConfigData->mailer,
                        'MAIL_FROM_ADDRESS' => $emailConfigData->fromAddress,
                        'MAIL_FROM_NAME' => "\"{$emailConfigData->fromName}\"",
                    ],
                    match ($emailConfigData->mailer) {
                        'sendmail' => [
                            'MAIL_SENDMAIL_PATH' => "\"{$emailConfigData->sendmailPath}\"",
                        ],
                        'smtp' => [
                            'MAIL_HOST' => $emailConfigData->smtpHost,
                            'MAIL_PORT' => $emailConfigData->smtpPort,
                            'MAIL_USERNAME' => $emailConfigData->smtpUsername,
                            'MAIL_PASSWORD' => $emailConfigData->smtpPassword,
                            'MAIL_ENCRYPTION' => $emailConfigData->smtpEncryption,
                        ],
                        'mailgun' => [
                            'MAILGUN_DOMAIN' => $emailConfigData->mailgunDomain,
                            'MAILGUN_SECRET' => "\"{$emailConfigData->mailgunSecret}\"",
                            'MAILGUN_ENDPOINT' => $emailConfigData->mailgunEndpoint,
                        ],
                        'mailersend' => [
                            'MAILERSEND_API_KEY' => "\"{$emailConfigData->mailersendApiKey}\"",
                        ],
                        'postmark' => [
                            'POSTMARK_TOKEN' => "\"{$emailConfigData->postmarkToken}\"",
                        ],
                        'ses' => [
                            'AWS_ACCESS_KEY_ID' => $emailConfigData->awsAccessKeyId,
                            'AWS_SECRET_ACCESS_KEY' => $emailConfigData->awsSecretAccessKey,
                            'AWS_DEFAULT_REGION' => $emailConfigData->awsDefaultRegion,
                        ],
                    }
                ));

                if (! $write) {
                    throw new Exception('error');
                }
            }
        }

        if ($emailData->imagePath !== null) {
            settings()->addMedia($emailData->imagePath)->toMediaCollection('email-logo');
        }

        return settings()->refresh();
    }
}
