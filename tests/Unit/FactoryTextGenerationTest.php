<?php

declare(strict_types=1);

use Database\Factories\AddonFactory;
use Database\Factories\AnnouncementFactory;
use Database\Factories\FormFactory;
use Database\Factories\FormFieldFactory;
use Database\Factories\NoteFactory;
use Database\Factories\PageFactory;
use Database\Factories\PositionFactory;
use Database\Factories\PostFactory;
use Database\Factories\RankGroupFactory;
use Database\Factories\RankNameFactory;
use Database\Factories\RoleFactory;
use Database\Factories\StoryFactory;
use Database\Factories\ThemeFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

it('generates definite string values for factory text fields', function (string $factory, array $fields) {
    /** @var Factory $factoryInstance */
    $factoryInstance = $factory::new();
    $definition = $factoryInstance->definition();

    foreach ($fields as $field) {
        expect($definition[$field])->toBeString()->not->toBeEmpty();
    }
})->with([
    'add-on' => [AddonFactory::class, ['name', 'location']],
    'announcement' => [AnnouncementFactory::class, ['title']],
    'form' => [FormFactory::class, ['key', 'name']],
    'form field' => [FormFieldFactory::class, ['label']],
    'note' => [NoteFactory::class, ['title']],
    'page' => [PageFactory::class, ['key']],
    'position' => [PositionFactory::class, ['name']],
    'post' => [PostFactory::class, ['title']],
    'rank group' => [RankGroupFactory::class, ['name']],
    'rank name' => [RankNameFactory::class, ['name']],
    'role' => [RoleFactory::class, ['name', 'display_name']],
    'story' => [StoryFactory::class, ['title']],
    'theme' => [ThemeFactory::class, ['name', 'location']],
]);

it('generates post content as a string', function () {
    $definition = PostFactory::new()->definition();

    expect($definition['content'](['post_type_id' => 4]))
        ->toBeString()
        ->toContain('<p>');
});
