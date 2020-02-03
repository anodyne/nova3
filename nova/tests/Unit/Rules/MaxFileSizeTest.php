<?php

namespace Tests\Unit\Rules;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Nova\Foundation\Rules\MaxFileSize;

class MaxFileSizeTest extends TestCase
{
    protected $maxFileSize;

    public function setUp(): void
    {
        parent::setUp();

        $this->maxFileSize = config('medialibrary.max_file_size');
    }

    /** @test **/
    public function imageUnderMaxFileSizeLimitPassesValidation()
    {
        $file = UploadedFile::fake()->create(
            'image.png',
            $this->maxFileSize / 1024
        );

        $this->assertTrue(
            (new MaxFileSize)->passes($file, $file)
        );
    }

    /** @test **/
    public function nullImagePassesValidation()
    {
        $this->assertTrue(
            (new MaxFileSize)->passes(null, null)
        );
    }

    /** @test **/
    public function imageOverMaxFileSizeLimitFailsValidation()
    {
        $file = UploadedFile::fake()->create(
            'image.png',
            $this->maxFileSize / 1024 + 1
        );

        $this->assertFalse(
            (new MaxFileSize)->passes($file, $file)
        );
    }
}
