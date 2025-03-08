<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Stories\Data\PostAuthorsData;
use Nova\Stories\Models\Post;
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

        $this->updatePostParticipants($post, $data);

        $post = $post->refresh();

        if ($sendNotifications) {
            $this->sendNotificationsToAddedAuthors($post, $data);

            $this->sendNotificationsToRemovedAuthors($post, $data);
        }

        return $post;
    }

    private function updateCharacterAuthors(Post $post, array $authors): void
    {
        $post->characterAuthors()->sync($authors);
    }

    private function updateUserAuthors(Post $post, array $authors): void
    {
        $post->userAuthors()->sync($authors);
    }

    private function updatePostParticipants(Post $post, PostAuthorsData $data): void
    {
        $participants = collect($post->participants)
            ->merge($data->getUserIds())
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $post->update(['participants' => $participants]);
    }

    private function sendNotificationsToAddedAuthors(Post $post, PostAuthorsData $data): void
    {
        $post->characterAuthors
            ->diff($data->originalCharacters)
            ->each(fn (Character $character) => $character->pivot->user->notify(new CharacterAuthorAddedToPost($post, $character)));

        $post->userAuthors
            ->diff($data->originalUsers)
            ->each->notify(new UserAuthorAddedToPost($post));
    }

    private function sendNotificationsToRemovedAuthors(Post $post, PostAuthorsData $data): void
    {
        $data->originalCharacters
            ->diff($post->characterAuthors)
            ->each(fn (Character $character) => $character->pivot->user->notify(new CharacterAuthorRemovedFromPost($post, $character)));

        $data->originalUsers
            ->diff($post->userAuthors)
            ->each->notify(new UserAuthorRemovedFromPost($post));
    }
}
