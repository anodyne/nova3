<?php

declare(strict_types=1);

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nova\Departments\Actions\UploadDepartmentHeaderImage;
use Nova\Departments\Models\Department;
use Tests\TestCase;

/**
 * @group departments
 * @group uploads
 * @group media
 */
class UploadDepartmentHeaderImageActionTest extends TestCase
{
    use RefreshDatabase;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->department = Department::factory()->create();
    }

    /** @test **/
    public function itStoresTheDepartmentHeader()
    {
        Storage::fake('media');

        $this->assertCount(0, $this->department->getMedia('header'));

        UploadDepartmentHeaderImage::run($this->department, UploadedFile::fake()->image('image.png'));

        $this->assertCount(1, $this->department->refresh()->getMedia('header'));
    }
}
