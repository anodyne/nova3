<?php

declare(strict_types=1);

use Nova\Stories\Enums\ContentRatingValue;
use Nova\Stories\Livewire\PostComposer;
use Nova\Stories\Livewire\PostRatings;
use Nova\Stories\Livewire\PostRatingsEditor;
use Nova\Stories\Models\Post;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('posts', 'storytelling', 'components');

beforeEach(function () {
    $this->post = Post::factory()->draft()->create();
    $this->post->update([
        'rating_language' => ContentRatingValue::Level1,
        'rating_sex' => ContentRatingValue::Level2,
        'rating_violence' => ContentRatingValue::Level3,
    ]);
});

describe('PostRatings', function () {
    test('mounts', function () {
        livewire(PostRatings::class, ['post' => $this->post])
            ->assertSet('postId', $this->post->id)
            ->assertSet('language', ContentRatingValue::Level1)
            ->assertSet('sex', ContentRatingValue::Level2)
            ->assertSet('violence', ContentRatingValue::Level3);
    });

    test('can open editor slide over', function () {
        livewire(PostRatings::class, ['post' => $this->post])
            ->call('openForEditing')
            ->assertDispatched('slide-over.open');
    });

    test('can save ratings', function () {
        livewire(PostRatings::class, ['post' => $this->post])
            ->set('language', ContentRatingValue::Level3)
            ->set('sex', ContentRatingValue::Level0)
            ->set('violence', ContentRatingValue::Level1)
            ->dispatch('save-post')
            ->assertDispatchedTo(PostComposer::class, 'save-post-completed');

        assertDatabaseHas(Post::class, [
            'id' => $this->post->id,
            'rating_language' => ContentRatingValue::Level3->value,
            'rating_sex' => ContentRatingValue::Level0->value,
            'rating_violence' => ContentRatingValue::Level1->value,
        ]);
    });

    test('can handle rating updates from PostRatingsEditor', function () {
        livewire(PostRatings::class, ['post' => $this->post])
            ->dispatch(
                'save-post-ratings',
                language: ContentRatingValue::Level0,
                sex: ContentRatingValue::Level1,
                violence: ContentRatingValue::Level2
            )
            ->assertSet('language', ContentRatingValue::Level0)
            ->assertSet('sex', ContentRatingValue::Level1)
            ->assertSet('violence', ContentRatingValue::Level2)
            ->assertDispatched('post-updated');
    });
});

describe('PostRatingsEditor', function () {
    test('mounts', function () {
        livewire(PostRatingsEditor::class, [
            'language' => $this->post->rating_language,
            'sex' => $this->post->rating_sex,
            'violence' => $this->post->rating_violence,
        ])
            ->assertSet('language', $this->post->rating_language)
            ->assertSet('sex', $this->post->rating_sex)
            ->assertSet('violence', $this->post->rating_violence);
    });

    test('sets the language rating', function () {
        livewire(PostRatingsEditor::class, [
            'language' => $this->post->rating_language,
            'sex' => $this->post->rating_sex,
            'violence' => $this->post->rating_violence,
        ])
            ->set('language', ContentRatingValue::Level0)
            ->assertSet('language', ContentRatingValue::Level0);
    });

    test('sets the sex rating', function () {
        livewire(PostRatingsEditor::class, [
            'language' => $this->post->rating_language,
            'sex' => $this->post->rating_sex,
            'violence' => $this->post->rating_violence,
        ])
            ->set('sex', ContentRatingValue::Level0)
            ->assertSet('sex', ContentRatingValue::Level0);
    });

    test('sets the violence rating', function () {
        livewire(PostRatingsEditor::class, [
            'language' => $this->post->rating_language,
            'sex' => $this->post->rating_sex,
            'violence' => $this->post->rating_violence,
        ])
            ->set('violence', ContentRatingValue::Level0)
            ->assertSet('violence', ContentRatingValue::Level0);
    });

    test('sends updated ratings back to the PostRatings component', function () {
        livewire(PostRatingsEditor::class, [
            'language' => $this->post->rating_language,
            'sex' => $this->post->rating_sex,
            'violence' => $this->post->rating_violence,
        ])
            ->set('language', ContentRatingValue::Level3)
            ->set('sex', ContentRatingValue::Level3)
            ->set('violence', ContentRatingValue::Level3)
            ->call('save')
            ->assertDispatched('save-post-ratings');
    });
});
