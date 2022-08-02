<?php

declare(strict_types=1);

use Nova\Foundation\WordGenerator;
use Tests\TestCase;

/**
 * @group words
 */
class WordGeneratorTest extends TestCase
{
    protected WordGenerator $generator;

    public function setUp(): void
    {
        parent::setUp();

        $this->generator = new WordGenerator();
    }

    /** @test */
    public function itCanGenerateWords()
    {
        $this->generator->words();

        $this->assertCount(1, $this->generator);
    }
}
