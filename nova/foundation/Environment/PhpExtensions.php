<?php

declare(strict_types=1);

namespace Nova\Foundation\Environment;

readonly class PhpExtensions
{
    public array $required;

    public array $loaded;

    public function __construct()
    {
        $this->required = collect($this->requiredExtensions())->flatMap(fn ($e): array => [$e['key']])->all();
        $this->loaded = get_loaded_extensions();
    }

    public function fails(): bool
    {
        return ! $this->passes();
    }

    public function passes(): bool
    {
        return empty($this->missingExtensions());
    }

    public function missingExtensions(): array
    {
        return array_diff($this->required, $this->loaded);
    }

    public function requiredExtensions(): array
    {
        return [
            ['key' => 'ctype', 'name' => 'Ctype'],
            ['key' => 'curl', 'name' => 'cURL'],
            ['key' => 'dom', 'name' => 'DOM'],
            ['key' => 'fileinfo', 'name' => 'Fileinfo'],
            ['key' => 'filter', 'name' => 'Filter'],
            ['key' => 'hash', 'name' => 'Hash'],
            ['key' => 'intl', 'name' => 'Internationalization'],
            ['key' => 'mbstring', 'name' => 'mbstring'],
            ['key' => 'openssl', 'name' => 'OpenSSL'],
            ['key' => 'pcre', 'name' => 'PCRE'],
            ['key' => 'PDO', 'name' => 'PDO'],
            ['key' => 'session', 'name' => 'Sessions'],
            ['key' => 'tokenizer', 'name' => 'Tokenizer'],
            ['key' => 'xml', 'name' => 'XML'],
        ];
    }
}
