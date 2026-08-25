<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Stringable;

/**
 * @method static static from(string $value, ?string $subject, ?string $object)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class PronounsData extends Bag implements Stringable
{
    public function __construct(
        public string $value,
        public ?string $subject,
        public ?string $object,
    ) {}

    public function __toString(): string
    {
        if ($this->value === 'none') {
            return '';
        }

        return implode('/', [
            $this->subject,
            $this->object,
        ]);
    }

    public static function getSubjectPronouns(string $pronoun, ?string $alternate): ?string
    {
        return match ($pronoun) {
            default => 'they',
            'female' => 'she',
            'male' => 'he',
            'none' => null,
            'other' => $alternate ? strtolower($alternate) : null,
        };
    }

    public static function getObjectPronouns(string $pronoun, ?string $alternate): ?string
    {
        return match ($pronoun) {
            default => 'them',
            'female' => 'her',
            'male' => 'him',
            'none' => null,
            'other' => $alternate ? strtolower($alternate) : null,
        };
    }

    /** @return array{value: mixed, subject: string|null, object: string|null} */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        $value = $request->input('pronouns.value');

        return [
            'value' => $value,
            'subject' => static::getSubjectPronouns($value, $request->input('pronouns.subject')),
            'object' => static::getObjectPronouns($value, $request->input('pronouns.object')),
        ];
    }

    #[Transforms('string')]
    protected static function fromJsonString(string $json): mixed
    {
        return [
            'value' => $json,
            'subject' => static::getSubjectPronouns($json, null),
            'object' => static::getObjectPronouns($json, null),
        ];
    }
}
