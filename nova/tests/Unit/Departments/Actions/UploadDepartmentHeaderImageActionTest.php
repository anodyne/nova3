<?php

declare(strict_types=1);
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nova\Departments\Actions\UploadDepartmentHeaderImage;
use Nova\Departments\Models\Department;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->department = Department::factory()->create();
});
it('stores the department header', function () {
    Storage::fake('media');

    expect($this->department->getMedia('header'))->toHaveCount(0);

    UploadDepartmentHeaderImage::run($this->department, UploadedFile::fake()->image('image.png'));

    expect($this->department->refresh()->getMedia('header'))->toHaveCount(1);
});
