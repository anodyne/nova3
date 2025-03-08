<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Models\Story;

trait InteractsWithStories
{
    public ?int $storyId = null;

    public function changeStory(int $newStoryId): void
    {
        $this->post->story_id = $newStoryId;

        $this->post->save();

        $this->post->moveToEnd();

        Notification::make()->success()
            ->title('Your post’s story has been updated')
            ->send();

        $this->redirectRoute('admin.posts.edit', $this->post);
    }

    public function getStory(): ?Story
    {
        return once(fn () => Story::find($this->storyId));
    }

    #[Computed]
    public function currentStories(): Collection
    {
        return Story::query()
            ->where(fn (Builder $query): Builder => $query->current()->orWhere('id', $this->storyId))
            ->get();
    }

    #[Computed]
    public function story(): ?Story
    {
        return Story::find($this->storyId);
    }
}
