<?php

declare(strict_types=1);

namespace Tests\Unit\Stories\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Stories\Actions\DeleteStory;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group stories
 */
class DeleteStoryActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeleteStory::class);

        $this->story = Story::factory()->create();
    }

    /** @test **/
    public function itDeletesAStory()
    {
        $story = $this->action->execute($this->story);

        $this->assertFalse($story->exists);
    }
}
