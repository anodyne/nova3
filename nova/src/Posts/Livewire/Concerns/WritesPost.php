<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Nova\Posts\Actions\DeletePost;
use Nova\Posts\Actions\SavePost;
use Nova\Posts\Actions\UpdatePostStatus;
use Nova\Posts\Data\PostData;
use Nova\Posts\Data\PostStatusData;
use Nova\Posts\Models\States\Draft;
use Throwable;

trait WritesPost
{
    public function daySelected($value): void
    {
        $this->post->day = $value;
    }

    public function locationSelected($value): void
    {
        $this->post->location = $value;
    }

    public function setPostContent($content): void
    {
        $this->post->content = $content;
    }

    public function timeSelected($value): void
    {
        $this->post->time = $value;
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

    public function delete()
    {
        $this->authorize('delete', $this->post);

        DeletePost::run($this->post);

        $message = $this->post->status === Draft::class
            ? "{$this->post->title} {str($this->postType->name)->lower()} draft has been discarded."
            : "{$this->post->title} {str($this->postType->name)->lower()} has been deleted.";

        redirect()->route('posts.create')->withToast($message);
    }

    public function save()
    {
        if ($this->canSave) {
            // $this->authorize('write', [$post, $this->postType]);

            $shouldRedirect = $this->postId === null;

            $this->post = UpdatePostStatus::run(
                SavePost::run($this->getPostData()),
                $this->getPostStatusData('draft')
            );

            $this->postId = $this->post->id;

            $this->dispatchBrowserEvent('toast', [
                'title' => $this->post->title . ' has been saved',
                'message' => null,
            ]);

            if ($shouldRedirect) {
                redirect()->route('posts.create', $this->post);
            }
        }
    }

    protected function getPostData(): PostData
    {
        $data = $this->post->getData();

        $data->post_type_id = $this->postType->id;
        $data->story_id = $this->story->id;

        return $data;
    }

    protected function getPostStatusData(string $status): PostStatusData
    {
        return PostStatusData::from([
            'status' => $status,
        ]);
    }
}
