<?php

declare(strict_types=1);

namespace Tests\Unit\PostTypes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\PostTypes\Actions\CreatePostType;
use Nova\PostTypes\Data\Field;
use Nova\PostTypes\Data\Fields;
use Nova\PostTypes\Data\Options;
use Nova\PostTypes\Data\PostTypeData;
use Tests\TestCase;

/**
 * @group stories
 * @group post-types
 */
class CreatePostTypeActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function itCreatesAPostType()
    {
        $data = PostTypeData::from([
            'key' => 'foo',
            'name' => 'Foo',
            'description' => 'Description of foo',
            'color' => '#000000',
            'icon' => 'book',
            'active' => true,
            'visibility' => 'in-character',
            'fields' => Fields::from([
                'title' => Field::From([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'day' => Field::From([
                    'enabled' => false,
                    'validate' => false,
                ]),
                'time' => Field::From([
                    'enabled' => false,
                    'validate' => false,
                ]),
                'location' => Field::From([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'content' => Field::From([
                    'enabled' => false,
                    'validate' => false,
                ]),
                'rating' => Field::From([
                    'enabled' => true,
                    'validate' => true,
                ]),
                'summary' => Field::From([
                    'enabled' => true,
                    'validate' => true,
                ]),
            ]),
            'options' => Options::from([
                'notifyUsers' => true,
                'notifyDiscord' => true,
                'includeInPostTracking' => false,
                'multipleAuthors' => true,
            ]),
        ]);

        $postType = CreatePostType::run($data);

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
