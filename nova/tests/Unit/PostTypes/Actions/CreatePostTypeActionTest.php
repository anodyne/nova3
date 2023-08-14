<?php

declare(strict_types=1);
use Nova\PostTypes\Actions\CreatePostType;
use Nova\PostTypes\Data\Field;
use Nova\PostTypes\Data\Fields;
use Nova\PostTypes\Data\Options;
use Nova\PostTypes\Data\PostTypeData;
use Nova\PostTypes\Enums\PostTypeStatus;
it('creates a post type', function () {
    $data = new PostTypeData(
        key: 'foo',
        name: 'Foo',
        description: 'Description of foo',
        color: '#000000',
        icon: 'book',
        status: PostTypeStatus::active,
        visibility: 'in-character',
        fields: Fields::from([
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
        options: Options::from([
            'notifiesUsers' => true,
            'includedInPostTracking' => false,
            'allowsMultipleAuthors' => true,
        ]),
        role_id: null
    );

    $postType = CreatePostType::run($data);

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
