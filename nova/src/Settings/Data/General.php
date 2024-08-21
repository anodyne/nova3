<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Nova\Foundation\Rules\Boolean;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class General extends Data implements Arrayable
{
    public function __construct(
        #[MapInputName('game_name')]
        public string $gameName,

        public string $dateFormat,
        public string $dateFormatTags,
        public bool $contactFormEnabled,

        #[MapInputName('contact_form_disabled_message')]
        public ?string $contactFormDisabledMessage
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'contactFormEnabled' => new Boolean,
        ];
    }

    public function jsDateFormat(): string
    {
        return str_replace(
            $this->dateFormatTokens(fn ($values) => [Arr::only($values, 'value')])->flatten()->all(),
            $this->dateFormatTokens(fn ($values) => [Arr::only($values, 'js')])->flatten()->all(),
            $this->dateFormat
        );
    }

    public function phpDateFormat(): string
    {
        return str_replace(
            $this->dateFormatTokens(fn ($values) => [Arr::only($values, 'value')])->flatten()->all(),
            $this->dateFormatTokens(fn ($values) => [Arr::only($values, 'php')])->flatten()->all(),
            $this->dateFormat
        );
    }

    public function dateFormatTokens($callback): Collection
    {
        $now = now();

        return collect([
            ['value' => '#year_short#', 'text' => "Year, short ({$now->format('y')})", 'php' => 'y', 'js' => 'yy'],
            ['value' => '#year_long#', 'text' => "Year, long ({$now->format('Y')})", 'php' => 'Y', 'js' => 'yyyy'],

            ['value' => '#month_short#', 'text' => "Month, short ({$now->format('M')})", 'php' => 'M', 'js' => 'MMM'],
            ['value' => '#month_long#', 'text' => "Month, long ({$now->format('F')})", 'php' => 'F', 'js' => 'MMMM'],
            ['value' => '#month_num#', 'text' => "Month, numeric ({$now->format('n')})", 'php' => 'n', 'js' => 'M'],
            ['value' => '#month_num2#', 'text' => "Month, numeric leading zero ({$now->format('m')})", 'php' => 'm', 'js' => 'MM'],

            ['value' => '#day_short#', 'text' => "Day, short ({$now->format('D')})", 'php' => 'D', 'js' => 'E..EEE'],
            ['value' => '#day_long#', 'text' => "Day, long ({$now->format('l')})", 'php' => 'l', 'js' => 'EEEE'],
            ['value' => '#day_num#', 'text' => "Day, numeric ({$now->format('j')})", 'php' => 'j', 'js' => 'd'],
            ['value' => '#day_num2#', 'text' => "Day, numeric leading zero ({$now->format('d')})", 'php' => 'd', 'js' => 'dd'],
            ['value' => '#day_ordinal#', 'text' => "Day, ordinal ({$now->format('jS')})", 'php' => 'jS', 'js' => 'do'],

            ['value' => '#hour_12#', 'text' => "Hour, 12-hour ({$now->format('g')})", 'php' => 'g', 'js' => 'h'],
            ['value' => '#hour_12_2#', 'text' => "Hour, 12-hour leading zero ({$now->format('h')})", 'php' => 'h', 'js' => 'hh'],
            ['value' => '#hour_24#', 'text' => "Hour, 24-hour ({$now->format('G')})", 'php' => 'G', 'js' => 'H'],
            ['value' => '#hour_24_2#', 'text' => "Hour, 24-hour leading zero ({$now->format('H')})", 'php' => 'H', 'js' => 'HH'],

            ['value' => '#minute#', 'text' => "Minute ({$now->format('i')})", 'php' => 'i', 'js' => 'mm'],
            ['value' => '#second#', 'text' => "Seconds ({$now->format('s')})", 'php' => 's', 'js' => 'ss'],
            ['value' => '#ampm_lower#', 'text' => "am/pm ({$now->format('a')})", 'php' => 'a', 'js' => 'aaa'],
            ['value' => '#ampm_upper#', 'text' => "AM/PM ({$now->format('A')})", 'php' => 'A', 'js' => 'a.aa'],
        ])->flatMap($callback);
    }

    public function dateFormatTokensArray(): array
    {
        return $this->dateFormatTokens(fn ($values) => [(object) Arr::only($values, ['value', 'text'])])->all();
    }

    public static function prepareForPipeline(array $properties): array
    {
        $properties['dateFormat'] = preg_replace(
            '/(\[\[{"value":"(#.+#)","text":".*"}\]\])/miU',
            '$2',
            $properties['dateFormatTags']
        );

        return $properties;
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            gameName: $request->input('game_name'),
            dateFormatTags: $request->input('dateFormatTags'),
            dateFormat: '',
            contactFormEnabled: $request->boolean('contactFormEnabled', true),
            contactFormDisabledMessage: $request->input('contact_form_disabled_message')
        );
    }
}
