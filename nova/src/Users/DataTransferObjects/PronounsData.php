<?php

declare(strict_types=1);

namespace Nova\Users\DataTransferObjects;

use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class PronounsData extends CastableDataTransferObject
{
    public string $value;

    public ?string $subject;

    public ?string $object;

    public ?string $possessive;

    public static function fromValue(array $pronouns = []): self
    {
        $value = data_get($pronouns, 'value');

        return new self(
            value: $value,
            subject: static::getSubjectPronouns($value, data_get($pronouns, 'subject')),
            object: static::getObjectPronouns($value, data_get($pronouns, 'object')),
            possessive: static::getPossessivePronouns($value, data_get($pronouns, 'possessive')),
        );
    }

    public static function getSubjectPronouns(string $pronoun, ?string $alternate): ?string
    {
        return match ($pronoun) {
            default => 'they',
            'female' => 'she',
            'male' => 'he',
            'neo' => 'ze',
            'none' => null,
            'other' => strtolower($alternate),
        };
    }

    public static function getObjectPronouns(string $pronoun, ?string $alternate): ?string
    {
        return match ($pronoun) {
            default => 'them',
            'female' => 'her',
            'male' => 'him',
            'neo' => 'zir',
            'none' => null,
            'other' => strtolower($alternate),
        };
    }

    public static function getPossessivePronouns(string $pronoun, ?string $alternate): ?string
    {
        return match ($pronoun) {
            default => 'theirs',
            'female' => 'hers',
            'male' => 'his',
            'neo' => 'zirs',
            'none' => null,
            'other' => strtolower($alternate),
        };
    }
}
