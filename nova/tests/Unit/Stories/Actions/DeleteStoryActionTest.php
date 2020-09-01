<?php

namespace Tests\Unit\Stories\Actions;

use Tests\TestCase;
use Nova\Stories\Models\Story;
use Nova\Stories\Actions\DeleteStory;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $this->story = create(Story::class);
    }

    /** @test **/
    public function itDeletesAStory()
    {
        $story = $this->action->execute($this->story);

        $this->assertFalse($story->exists);
    }
}
