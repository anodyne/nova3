<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class EmailConfiguration extends Data implements Arrayable
{
    public function __construct(
        public ?string $mailer,

        public ?string $fromAddress,
        public ?string $fromName,

        public ?string $sendmailPath,

        public ?string $smtpHost,
        public ?string $smtpPort,
        public ?string $smtpUsername,
        public ?string $smtpPassword,
        public ?string $smtpEncryption,

        public ?string $mailgunDomain,
        public ?string $mailgunSecret,
        public ?string $mailgunEndpoint,

        public ?string $mailersendApiKey,

        public ?string $postmarkToken,

        public ?string $awsAccessKeyId,
        public ?string $awsSecretAccessKey,
        public ?string $awsDefaultRegion
    ) {}
}
