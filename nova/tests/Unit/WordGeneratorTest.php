<?php

namespace Tests\Unit;

use Tests\TestCase;
use Nova\Foundation\WordGenerator;

class WordGeneratorTest extends TestCase
{
    protected $generator;

    public function setUp(): void
    {
        parent::setUp();

        $this->generator = new WordGenerator;
    }

    public function testItCanGenerateRandomWord()
    {
        $words = $this->generator->words();

        $this->assertCount(1, $words);
    }
}
