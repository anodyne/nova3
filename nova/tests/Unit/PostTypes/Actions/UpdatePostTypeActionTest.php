<?php

declare(strict_types=1);
use Nova\Stories\Actions\UpdatePostType;
use Nova\Stories\Data\Field;
use Nova\Stories\Data\Fields;
use Nova\Stories\Data\Options;
use Nova\Stories\Data\PostTypeData;
use Nova\Stories\Enums\PostTypeStatus;
use Nova\Stories\Models\PostType;

beforeEach(function () {
    $this->postType = PostType::factory()->create();
});
it('updates a post type', function () {
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

    expect($postType->exists)->toBeTrue();
    expect($postType->name)->toEqual('Foo');
    expect($postType->key)->toEqual('foo');
    expect($postType->description)->toEqual('Description of foo');
    expect($postType->icon)->toEqual('book');
    expect($postType->color)->toEqual('#000000');
    expect($postType->visibility)->toEqual('in-character');
    expect($postType->status === PostTypeStatus::active)->toBeTrue();
    expect($postType->role_id)->toBeNull();

    expect($postType->fields->title->enabled)->toBeTrue();
    expect($postType->fields->day->enabled)->toBeFalse();
    expect($postType->fields->time->enabled)->toBeFalse();
    expect($postType->fields->location->enabled)->toBeTrue();
    expect($postType->fields->content->enabled)->toBeFalse();
    expect($postType->fields->rating->enabled)->toBeTrue();
    expect($postType->fields->summary->enabled)->toBeTrue();

    expect($postType->options->notifiesUsers)->toBeTrue();
    expect($postType->options->includedInPostTracking)->toBeFalse();
    expect($postType->options->allowsMultipleAuthors)->toBeTrue();
});
