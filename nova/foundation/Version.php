<?php

declare(strict_types=1);

namespace Nova\Foundation;

use Mistralys\VersionParser\VersionParser;

class Version
{
    protected VersionParser $parser;

    public function __construct(string $version)
    {
        $this->parser = VersionParser::create($version);
    }

    public function long(): string
    {
        return $this->parser->getTagVersion();
    }

    public function short(): string
    {
        return sprintf('%s.%s', $this->parser->getMajorVersion(), $this->parser->getMinorVersion());
    }

    public static function make(string $version): self
    {
        return new self($version);
    }
}
