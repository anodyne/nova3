<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Stories\Data\PostAuthorsData;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Stories\Notifications\CharacterAuthorAddedToPost;
use Nova\Stories\Notifications\CharacterAuthorRemovedFromPost;
use Nova\Stories\Notifications\UserAuthorAddedToPost;
use Nova\Stories\Notifications\UserAuthorRemovedFromPost;

class UpdatePostAuthors
{
    use AsAction;

    public function handle(Post $post, PostAuthorsData $data, bool $sendNotifications = true): Post
    {
        $this->updateCharacterAuthors($post, $data->characters);

        $this->updateUserAuthors($post, $data->users);

        $post = $post->refresh();

        if ($sendNotifications) {
            $this->sendNotificationsToAddedAuthors($post, $data);

            $this->sendNotificationsToRemovedAuthors($post, $data);
        }

        return $post;
    }

    private function getAuthorship(Character $character): ?PostAuthor
    {
        if (! $character->relationLoaded('authorship')) {
            return null;
        }

        $authorship = $character->getRelation('authorship');

        return $authorship instanceof PostAuthor
            ? $authorship
            : null;
    }

    private function sendNotificationsToAddedAuthors(Post $post, PostAuthorsData $data): void
    {
        $post->characterAuthors
            ->diff($data->originalCharacters)
            ->each(function (Character $character) use ($post): void {
                $this->getAuthorship($character)
                    ?->user
                    ?->notify(new CharacterAuthorAddedToPost($post, $character));
            });

        $post->userAuthors
            ->diff($data->originalUsers)
            ->each->notify(new UserAuthorAddedToPost($post));
    }

    private function sendNotificationsToRemovedAuthors(Post $post, PostAuthorsData $data): void
    {
        $data->originalCharacters
            ->diff($post->characterAuthors)
            ->each(function (Character $character) use ($post): void {
                $this->getAuthorship($character)
                    ?->user
                    ?->notify(new CharacterAuthorRemovedFromPost($post, $character));
            });

        $data->originalUsers
            ->diff($post->userAuthors)
            ->each->notify(new UserAuthorRemovedFromPost($post));
    }

    private function updateCharacterAuthors(Post $post, array $authors): void
    {
        $post->characterAuthors()->sync($authors);
    }

    private function updateUserAuthors(Post $post, array $authors): void
    {
        $post->userAuthors()->sync($authors);
    }
}
