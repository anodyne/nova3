<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Nova\Posts\Actions\DeletePost;
use Nova\Posts\Actions\SavePostManager;
use Nova\Posts\Data\PostAuthorsData;
use Nova\Posts\Data\PostData;
use Nova\Posts\Data\PostPositionData;
use Nova\Posts\Data\PostStatusData;
use Nova\Posts\Models\States\Draft;
use Nova\Posts\Models\States\Published;
use Nova\Posts\Models\States\Started;
use Nova\Posts\Notifications\DraftPostDiscarded;
use Nova\Posts\Notifications\PostSaved;
use Nova\Users\Models\User;
use Throwable;

trait WritesPost
{
    public array $characterAuthors = [];

    public array $userAuthors = [];

    public function authorsSelected(array $authors): void
    {
        [$characterAuthors, $userAuthors] = $authors;

        $this->characterAuthors = $characterAuthors;
        $this->userAuthors = $userAuthors;
    }

    public function daySelected($value): void
    {
        $this->post->update(['day' => $value]);
    }

    public function locationSelected($value): void
    {
        $this->post->update(['location' => $value]);
    }

    public function setPostContent($content): void
    {
        $this->post->update([
            'content' => $content,
            'word_count' => str($content)->pipe('strip_tags')->wordCount(),
        ]);
    }

    public function setPostTitle($value): void
    {
        $this->post->update(['title' => $value]);
    }

    public function setPostSummary($value): void
    {
        $this->post->update(['summary' => $value]);
    }

    public function timeSelected($value): void
    {
        $this->post->update(['time' => $value]);
    }

    public function getCanSaveProperty(): bool
    {
        if (! $this->postType->exists) {
            return false;
        }

        try {
            return is_array($this->validate());
        } catch (Throwable $th) {
            return false;
        }
    }

    public function getCanSaveMessageProperty(): string
    {
        return sprintf(
            'To save your %s, please add a %s.',
            str($this->postType->name)->lower(),
            count($keys = $this->postType->fields->requiredFields()->keys()) === 2
                ? $keys->join(', ', ' and ')
                : $keys->join(', ', ', and ')
        );
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->post);

        $this->dispatchBrowserEvent('dropdown-close');

        $this->post->participatingUsers
            ->filter(fn (User $user) => $user->id !== auth()->id())
            ->each->notify(new DraftPostDiscarded($this->post));

        DeletePost::run($this->post);

        $message = $this->post->status->equals(Draft::class)
            ? $this->post->title . ' ' . str($this->postType->name)->lower() . ' draft has been discarded.'
            : $this->post->title . ' ' . str($this->postType->name)->lower() . ' has been deleted.';

        redirect()->route('writing-overview')->withToast($message);
    }

    public function save($quiet = false, $allowRedirect = true): void
    {
        if ($this->canSave) {
            $this->authorize('write', [$this->post, $this->postType]);

            $shouldRedirect = false;

            if ($this->post->status->equals(Started::class)) {
                if ($allowRedirect) {
                    $shouldRedirect = true;
                }

                $this->post->status->transitionTo(Draft::class);
            }

            $this->post->addParticipant(auth()->user());

            $this->post->participatingUsers
                ->filter(fn ($user) => $user->id !== auth()->id())
                ->each->notify(new PostSaved($this->post, auth()->user()));

            $this->postId = $this->post->id;

            if (! $quiet) {
                $this->dispatchBrowserEvent('toast', [
                    'title' => $this->post->title . ' has been saved',
                    'message' => null,
                ]);
            }

            if ($shouldRedirect) {
                redirect()->route('posts.create', $this->post);
            }
        }
    }

    public function saveQuietly(): void
    {
        $this->save(true);
    }

    public function saveQuietlyWithoutRedirect(): void
    {
        $this->save(true, false);
    }
}
