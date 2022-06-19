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
use Nova\Posts\Models\States\Started;
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
        $this->post->update(['content' => $content]);
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

        DeletePost::run($this->post);

        $message = $this->post->status === Draft::class
            ? "{$this->post->title} {str($this->postType->name)->lower()} draft has been discarded."
            : "{$this->post->title} {str($this->postType->name)->lower()} has been deleted.";

        redirect()->route('posts.create')->withToast($message);
    }

    public function save($quiet = false): void
    {
        if ($this->canSave) {
//             $this->authorize('write', [$this->post, $this->postType]);

            $shouldRedirect = false;

            if ($this->post->status->equals(Started::class)) {
                $shouldRedirect = true;

                $this->post->status->transitionTo(Draft::class);
            }

//            $this->post = SavePostManager::run(
//                $this->getPostData(),
//                $this->getPostStatusData('draft'),
//                $this->getPostPositionData(),
//                $this->getPostAuthorsData()
//            );

//            $this->post = UpdatePostStatus::run(
//                SavePost::run($this->getPostData()),
//                $this->getPostStatusData('draft')
//            );

//            $this->post = SetPostPosition::run(
//                $this->post,
//                $this->getPostPositionData()
//            );

//            $this->post = SetPostAuthors::run(
//                $this->post,
//                $this->getPostAuthorsData()
//            );

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

    protected function getPostData(): PostData
    {
        $data = $this->post->getData();

        $data->post_type_id = $this->postType->id;
        $data->story_id = $this->story->id;

        $data->rating_language = $this->ratingLanguage;
        $data->rating_sex = $this->ratingSex;
        $data->rating_violence = $this->ratingViolence;

        $data->setWordCount();

        return $data;
    }

    protected function getPostStatusData(string $status): PostStatusData
    {
        return PostStatusData::from([
            'status' => $status,
        ]);
    }

    protected function getPostPositionData(): PostPositionData
    {
        return PostPositionData::from([
            'hasPositionChange' => false,
            'displayDirection' => $this->state()->forStep('posts:step:publish-post')['direction'],
            'displayNeighbor' => $this->state()->forStep('posts:step:publish-post')['neighbor'],
        ]);
    }

    protected function getPostAuthorsData(): PostAuthorsData
    {
        return PostAuthorsData::from([
            'characters' => $this->characterAuthors,
            'users' => $this->userAuthors,
        ]);
    }
}
