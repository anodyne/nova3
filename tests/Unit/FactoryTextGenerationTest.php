<?php

declare(strict_types=1);

use Database\Factories\AddonFactory;
use Database\Factories\AnnouncementFactory;
use Database\Factories\BanFactory;
use Database\Factories\FormFactory;
use Database\Factories\FormFieldFactory;
use Database\Factories\FormSubmissionFactory;
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
use Nova\Addons\Models\Addon;
use Nova\Users\Models\User;

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

it('builds request data around one add-on model', function () {
    $requestData = AddonFactory::new()->forRequest();

    expect($requestData->model)->toBeInstanceOf(Addon::class)
        ->and($requestData->payload)->toBeArray()->not->toBeEmpty();
});

it('uses the user morph type without querying a related model', function () {
    $morphType = (new User)->getMorphClass();
    $ban = BanFactory::new()->definition();
    $formSubmission = FormSubmissionFactory::new()->definition();

    expect($ban['bannable_type'])->toBe($morphType)
        ->and($ban['created_by_type'])->toBe($morphType)
        ->and($formSubmission['owner_type'])->toBe($morphType);
});
