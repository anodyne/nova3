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

    protected $action;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UploadDepartmentHeaderImage::class);

        $this->department = Department::factory()->create();
    }

    /** @test **/
    public function itStoresTheDepartmentHeader()
    {
        $disk = Storage::fake('media');

        $diskPathPrefix = $disk->getAdapter()->getPathPrefix();

        $this->assertCount(0, $this->department->getMedia('header'));

        config()->set('filesystems.disks.media', [
            'driver' => 'local',
            'root' => $diskPathPrefix,
        ]);

        $path = $disk->put('tmp', UploadedFile::fake()->image('image.png'));

        $this->action->execute($this->department, $diskPathPrefix . $path);

        $this->assertCount(1, $this->department->refresh()->getMedia('header'));
    }
}
