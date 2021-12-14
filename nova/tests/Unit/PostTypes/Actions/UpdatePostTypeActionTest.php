<?php

declare(strict_types=1);

namespace Tests\Unit\PostTypes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\PostTypes\Actions\UpdatePostType;
use Nova\PostTypes\DataTransferObjects\PostTypeData;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Values\Field;
use Nova\PostTypes\Values\Fields;
use Nova\PostTypes\Values\Options;
use Tests\TestCase;

/**
 * @group stories
 * @group post-types
 */
class UpdatePostTypeActionTest extends TestCase
{
    use RefreshDatabase;

    protected $postType;

    public function setUp(): void
    {
        parent::setUp();

        $this->postType = PostType::factory()->create();
    }

    /** @test **/
    public function itUpdatesAPostType()
    {
        $data = new PostTypeData([
            'key' => 'foo',
            'name' => 'Foo',
            'description' => 'Description of foo',
            'color' => '#000000',
            'icon' => 'book',
            'active' => true,
            'visibility' => 'in-character',
            'fields' => new Fields([
                'title' => new Field([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'day' => new Field([
                    'enabled' => false,
                    'validate' => false,
                ]),
                'time' => new Field([
                    'enabled' => false,
                    'validate' => false,
                ]),
                'location' => new Field([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'content' => new Field([
                    'enabled' => false,
                    'validate' => false,
                ]),
                'rating' => new Field([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'summary' => new Field([
                    'enabled' => true,
                    'validate' => true,
                ]),
            ]),
            'options' => new Options([
                'notifyUsers' => true,
                'notifyDiscord' => true,
                'includeInPostTracking' => false,
                'multipleAuthors' => true,
            ]),
        ]);

        $postType = UpdatePostType::run($this->postType, $data);

        $this->assertTrue($postType->exists);
        $this->assertEquals('Foo', $postType->name);
        $this->assertEquals('foo', $postType->key);
        $this->assertEquals('Description of foo', $postType->description);
        $this->assertEquals('book', $postType->icon);
        $this->assertEquals('#000000', $postType->color);
        $this->assertEquals('in-character', $postType->visibility);
        $this->assertTrue($postType->active);

        $this->assertTrue($postType->fields->title->enabled);
        $this->assertFalse($postType->fields->day->enabled);
        $this->assertFalse($postType->fields->time->enabled);
        $this->assertTrue($postType->fields->location->enabled);
        $this->assertFalse($postType->fields->content->enabled);
        $this->assertTrue($postType->fields->rating->enabled);
        $this->assertTrue($postType->fields->summary->enabled);

        $this->assertTrue($postType->options->notifyUsers);
        $this->assertTrue($postType->options->notifyDiscord);
        $this->assertFalse($postType->options->includeInPostTracking);
        $this->assertTrue($postType->options->multipleAuthors);
    }
}
