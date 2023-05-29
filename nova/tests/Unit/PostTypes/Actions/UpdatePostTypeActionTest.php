<?php

declare(strict_types=1);

namespace Tests\Unit\PostTypes\Actions;

use Nova\PostTypes\Actions\UpdatePostType;
use Nova\PostTypes\Data\Field;
use Nova\PostTypes\Data\Fields;
use Nova\PostTypes\Data\Options;
use Nova\PostTypes\Data\PostTypeData;
use Nova\PostTypes\Enums\PostTypeStatus;
use Nova\PostTypes\Models\PostType;
use Tests\TestCase;

/**
 * @group storytelling
 * @group post-types
 */
class UpdatePostTypeActionTest extends TestCase
{
    protected $postType;

    public function setUp(): void
    {
        parent::setUp();

        $this->postType = PostType::factory()->create();
    }

    /** @test **/
    public function itUpdatesAPostType()
    {
        $data = new PostTypeData(
            key: 'foo',
            name: 'Foo',
            description: 'Description of foo',
            color: '#000000',
            icon: 'book',
            status: PostTypeStatus::active,
            visibility: 'in-character',
            fields: Fields::from([
                'title' => Field::from([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'day' => Field::from([
                    'enabled' => false,
                    'validate' => false,
                ]),
                'time' => Field::from([
                    'enabled' => false,
                    'validate' => false,
                ]),
                'location' => Field::from([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'content' => Field::from([
                    'enabled' => false,
                    'validate' => false,
                ]),
                'rating' => Field::from([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'summary' => Field::from([
                    'enabled' => true,
                    'validate' => true,
                ]),
            ]),
            options: Options::from([
                'notifiesUsers' => true,
                'includedInPostTracking' => false,
                'allowsMultipleAuthors' => true,
            ]),
            role_id: null
        );

        $postType = UpdatePostType::run($this->postType, $data);

        $this->assertTrue($postType->exists);
        $this->assertEquals('Foo', $postType->name);
        $this->assertEquals('foo', $postType->key);
        $this->assertEquals('Description of foo', $postType->description);
        $this->assertEquals('book', $postType->icon);
        $this->assertEquals('#000000', $postType->color);
        $this->assertEquals('in-character', $postType->visibility);
        $this->assertTrue($postType->status === PostTypeStatus::active);
        $this->assertNull($postType->role_id);

        $this->assertTrue($postType->fields->title->enabled);
        $this->assertFalse($postType->fields->day->enabled);
        $this->assertFalse($postType->fields->time->enabled);
        $this->assertTrue($postType->fields->location->enabled);
        $this->assertFalse($postType->fields->content->enabled);
        $this->assertTrue($postType->fields->rating->enabled);
        $this->assertTrue($postType->fields->summary->enabled);

        $this->assertTrue($postType->options->notifiesUsers);
        $this->assertFalse($postType->options->includedInPostTracking);
        $this->assertTrue($postType->options->allowsMultipleAuthors);
    }
}
