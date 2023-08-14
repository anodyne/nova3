<?php

declare(strict_types=1);
use Illuminate\Http\UploadedFile;
use Nova\Media\Rules\MaxFileSize;
beforeEach(function () {
    $this->maxFileSize = config('medialibrary.max_file_size');
});
test('image under max file size limit passes validation', function () {
    $file = UploadedFile::fake()->create(
        'image.png',
        $this->maxFileSize / 1024
    );

    expect((new MaxFileSize())->passes($file, $file))->toBeTrue();
});
test('null image passes validation', function () {
    expect((new MaxFileSize())->passes(null, null))->toBeTrue();
});
test('image over max file size limit fails validation', function () {
    $file = UploadedFile::fake()->create(
        'image.png',
        $this->maxFileSize / 1024 + 1
    );

    expect((new MaxFileSize())->passes($file, $file))->toBeFalse();
});
