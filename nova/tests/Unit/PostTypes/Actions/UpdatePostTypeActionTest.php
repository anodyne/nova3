<?php

namespace Tests\Unit\PostTypes\Actions;

use Tests\TestCase;
use Nova\PostTypes\Actions\CreatePostType;
use Nova\PostTypes\DataTransferObjects\Fields;
use Nova\PostTypes\DataTransferObjects\Options;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\PostTypes\Actions\UpdatePostType;
use Nova\PostTypes\DataTransferObjects\PostTypeData;
use Nova\PostTypes\Models\PostType;

/**
 * @group stories
 * @group post-types
 */
class UpdatePostTypeActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $postType;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdatePostType::class);

        $this->postType = create(PostType::class);

        $this->postType->fields = Fields::fromArray([
            'title' => true,
            'time' => true,
            'location' => true,
            'content' => true,
        ]);
        $this->postType->options = Options::fromArray([
            'notifyUsers' => true,
            'includeInPostCounts' => true,
            'multipleAuthors' => true,
        ]);

        $this->postType->save();
    }

    /** @test **/
    public function itUpdatesAPostType()
    {
        $data = new PostTypeData([
            'key' => 'foo',
            'name' => 'Foo',
            'description' => 'Description of foo',
            'active' => true,
            'visibility' => 'in-character',
            'fields' => new Fields([
                'title' => true,
                'time' => false,
                'location' => true,
                'content' => false,
            ]),
            'options' => new Options([
                'notifyUsers' => true,
                'notifyDiscord' => true,
                'includeInPostCounts' => false,
                'multipleAuthors' => true,
            ]),
        ]);

        $postType = $this->action->execute($this->postType, $data);

        $this->assertTrue($postType->exists);
        $this->assertEquals('Foo', $postType->name);
        $this->assertEquals('foo', $postType->key);
        $this->assertEquals('Description of foo', $postType->description);
        $this->assertEquals('in-character', $postType->visibility);
        $this->assertTrue($postType->active);

        $this->assertTrue($postType->fields->title);
        $this->assertFalse($postType->fields->time);
        $this->assertTrue($postType->fields->location);
        $this->assertFalse($postType->fields->content);

        $this->assertTrue($postType->options->notifyUsers);
        $this->assertTrue($postType->options->notifyDiscord);
        $this->assertFalse($postType->options->includeInPostCounts);
        $this->assertTrue($postType->options->multipleAuthors);
    }
}
