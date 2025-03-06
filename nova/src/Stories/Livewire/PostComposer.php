<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Carbon\CarbonInterface;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Models\Post;

class PostComposer extends Component
{
    #[Locked]
    public Post $post;

    public ?CarbonInterface $lastUpdate = null;

    public int $savedChildrenCount = 0;

    public function handleUpdateFromChild(): void
    {
        $this->lastUpdate = now();
    }

    public function save(): void
    {
        $this->savedChildrenCount = 0;

        foreach ($this->childrenComponents() as $component) {
            $this->dispatch('save-post')->to($component);
        }

        $this->lastUpdate = null;
    }

    public function mount(?Post $post = null): void
    {
        $post?->exists
            ? $this->mountForPostEditing($post)
            : $this->mountForPostCreation($post);
    }

    public function render(): View
    {
        $view = $this->post->exists ? 'post-composer' : 'post-setup';

        return view("pages.posts.livewire.$view", [
            'postIsDirty' => $this->isDirty,
        ]);
    }

    #[Computed]
    public function isDirty(): bool
    {
        return $this->lastUpdate !== null;
    }

    #[On('save-post-completed')]
    #[Renderless]
    public function checkAllSaved(): void
    {
        $this->savedChildrenCount++;

        $totalChildren = count($this->childrenComponents());

        if ($this->savedChildrenCount === $totalChildren) {
            Notification::make()->success()
                ->title('Post saved')
                ->send();

            $this->savedChildrenCount = 0;
        }
    }

    private function childrenComponents(): array
    {
        $components = [
            PostDetails::class,
            PostAuthors::class,
        ];

        if ($this->post?->postType?->fields?->rating?->enabled) {
            $components[] = PostRatings::class;
        }

        $components[] = PostPosition::class;

        return $components;
    }

    private function mountForPostCreation(Post $post): void
    {
        $this->post = $post;
    }

    private function mountForPostEditing(Post $post): void
    {
        $this->post = $post->loadMissing([
            'characterAuthors.activeUsers',
            'participatingUsers',
            'postType',
            'story',
            'userAuthors',
        ]);
    }
}
