<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Support\Facades\Auth;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\Concerns\InteractsWithConfirmationModal;
use Nova\Stories\Models\PostType;

trait InteractsWithPostTypeChanges
{
    use InteractsWithConfirmationModal;

    public function changePostType(PostType $oldPostType, PostType $newPostType): void
    {
        $this->post->post_type_id = $newPostType->id;

        $this->handlePostTypeUpdateForDetails($oldPostType, $newPostType);

        $this->handlePostTypeUpdateForRatings($oldPostType, $newPostType);

        $this->handlePostTypeUpdateForSummary($oldPostType, $newPostType);

        $this->post->save();

        $this->handlePostTypeUpdateForAuthors($oldPostType, $newPostType);

        Notification::make()->success()
            ->title('Post type has been updated')
            ->body('Some of your post data may have been updated as part of the post type change, including authors, depending on the configured fields and options of the post type you changed to. Please review your post thoroughly before publishing.')
            ->send();

        $this->redirectRoute('admin.posts.edit', $this->post);
    }

    public function startPostTypeChange(int $newPostTypeId): void
    {
        $oldPostType = $this->postType;
        $newPostType = PostType::find($newPostTypeId);

        $this->askForConfirmation(
            callback: fn () => $this->changePostType($oldPostType, $newPostType),
            prompt: [
                'title' => 'Change post type?',
                'icon' => 'edit-settings',
                'message' => __('messages.change-post-type', [
                    'old' => $oldPostType->name,
                    'new' => $newPostType->name,
                ]),
                'confirm' => 'Yes, change post type',
                'cancel' => 'Cancel',
            ],
            theme: 'warning',
        );
    }

    private function handlePostTypeUpdateForAuthors(PostType $oldPostType, PostType $newPostType): void
    {
        /**
         * If we're going to a post type that allows multiple authors, we don't
         * need to do anything. If the old post type didn't allow multiple authors
         * then we're good. If the old post type did allow multiple authors, then
         * there's no reason to make any changes.
         */
        if ($newPostType->options->allowsMultipleAuthors) {
            return;
        }

        /**
         * We're moving to a post type that doesn't allow multiple authors, but
         * our old post type did allow multiple authors, so we need to make
         * some changes to our post.
         */
        if ($oldPostType->options->allowsMultipleAuthors && ! $newPostType->options->allowsMultipleAuthors) {
            // It doesn't matter, because we only have 1 author on the post.
            if ($this->post->characterAuthors->count() + $this->post->userAuthors->count() === 1) {
                return;
            }

            /**
             * We're moving to a post type that doesn't allow character authors,
             * but our old post type did allow character authors, so we need to
             * make some changes to our post.
             */
            if ($oldPostType->options->allowsCharacterAuthors && ! $newPostType->options->allowsCharacterAuthors) {
                // It doesn't matter, because we don't have any character authors
                if ($this->post->characterAuthors->count() === 0) {
                    return;
                }

                /**
                 * We're going to be removing all character authors here, so we
                 * need to make sure that the current user is added as a user
                 * author so they retain access to the post.
                 */
                $this->post->userAuthors()->syncWithoutDetaching([
                    Auth::id() => ['as' => null, 'user_id' => Auth::id()],
                ]);

                // Remove all character authors
                $this->post->characterAuthors()->detach();
            }

            /**
             * We're moving to a post type that doesn't allow user authors,
             * but our old post type did allow user authors, so we need to
             * make some changes to our post.
             */
            if ($oldPostType->options->allowsUserAuthors && ! $newPostType->options->allowsUserAuthors) {
                // It doesn't matter, because we don't have any user authors.
                if ($this->post->userAuthors->count() === 0) {
                    return;
                }

                /**
                 * We're going to be removing all user authors here, so we
                 * need to make sure that the current user is added as a
                 * character author so they retain access to the post.
                 * In order to do this, we'll simply grab their primary
                 * character and add it to the post.
                 */
                $userCharacter = Auth::user()->primaryCharacter->first() ?? Auth::user()->activeCharacters->first();

                $this->post->characterAuthors()->syncWithoutDetaching([
                    $userCharacter->id => ['user_id' => Auth::id()],
                ]);

                // Remove all user authors
                $this->post->userAuthors()->detach();
            }
        }

        /**
         * For post authors, we need to see if we're going from a post that
         * allows multiple authors to one that doesn't. If that's the case
         * then we need to remove all authors except for the first character
         * author owned by the user (unless the post type only allows user
         * authors, in which case, we just set the current user as the author
         * of the post).
         */
    }

    private function handlePostTypeUpdateForDetails(PostType $oldPostType, PostType $newPostType): void
    {
        /**
         * Get the enabled fields for the old post type, removing the rating
         * and summary fields (since we'll handle those separately).
         */
        $oldFields = $oldPostType->fields->enabledFields()
            ->reject(fn ($field, string $key) => in_array($key, ['rating', 'summary']));

        /**
         * Get the enabled fields for the new post type, removing the rating
         * and summary fields (since we'll handle those separate).
         */
        $newFields = $newPostType->fields->enabledFields()
            ->reject(fn ($field, string $key) => in_array($key, ['rating', 'summary']));

        /**
         * Determine what fields are being removed when we move the post to the
         * new post type.
         */
        $removedFields = $oldFields->keys()->diff($newFields->keys())->values();

        /**
         * Loop through the fields being removed and null the values on the post.
         */
        $removedFields->each(fn (string $fieldName) => $this->post->$fieldName = null);
    }

    private function handlePostTypeUpdateForRatings(PostType $oldPostType, PostType $newPostType): void
    {
        /**
         * If the new post type doesn't have the ratings field enabled, update
         * the post ratings to the game defaults.
         */
        if (! $newPostType->fields->rating->enabled) {
            $gameRatings = settings('ratings');

            $this->post->rating_language = $gameRatings->language->rating;
            $this->post->rating_sex = $gameRatings->sex->rating;
            $this->post->rating_violence = $gameRatings->violence->rating;
        }
    }

    private function handlePostTypeUpdateForSummary(PostType $oldPostType, PostType $newPostType): void
    {
        /**
         * If the new post type doesn't have the summary field enabled, update
         * the post summary to be null.
         */
        if (! $newPostType->fields->summary->enabled) {
            $this->post->summary = null;
        }
    }
}
