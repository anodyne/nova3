<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Steps;

use Livewire\Attributes\Computed;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Livewire\Concerns\HasParentState;
use Nova\Stories\Livewire\PostForm;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\PostStatus\Draft;
use Nova\Stories\Notifications\PostSaved;
use Nova\Users\Models\User;
use Throwable;

class ComposePostStep extends WizardStep
{
    use HasParentState;

    public PostForm $form;

    public ?Post $post = null;

    public function stepInfo(): array
    {
        return [
            'label' => 'Write your post',
        ];
    }

    #[Computed]
    public function canSave(): bool
    {
        try {
            return is_array($this->form->validate());
        } catch (Throwable $th) {
            return false;
        }
    }

    #[Computed]
    public function canSaveMessage(): string
    {
        return sprintf(
            'To save your %s, please add a %s',
            str($this->postType->name)->lower(),
            count($keys = $this->postType->fields->requiredFields()->keys()) === 2
                ? $keys->join(', ', ' and ')
                : $keys->join(', ', ', and ')
        );
    }

    public function save($quiet = false, $allowRedirect = true): void
    {
        $this->authorize('write', [$this->post, $this->post->postType]);

        $shouldRedirect = false;

        $this->form->validate();

        $this->form->save();

        $this->post->addParticipant(auth()->user());

        if ($this->post->is_started) {
            if ($allowRedirect) {
                $shouldRedirect = true;
            }

            $this->post->status->transitionTo(Draft::class);
        }

        $this->post->participatingUsers
            ->filter(fn (User $user) => $user->id !== auth()->id())
            ->each->notify(new PostSaved($this->post, auth()->user()));

        if (! $quiet) {
            Notification::make()
                ->success()
                ->title(($this->post->title ?? $this->postType->name).' has been saved')
                ->send();
        }

        if ($shouldRedirect) {
            redirect()->route('admin.posts.edit', $this->post);
        }
    }

    public function saveQuietly(): void
    {
        $this->save(quiet: true);
    }

    public function saveQuietlyWithoutRedirect(): void
    {
        $this->save(quiet: true, allowRedirect: false);
    }

    public function goToNextStep(): void
    {
        $this->saveQuietlyWithoutRedirect();

        $this->dispatch('refreshPost', $this->post->id);

        $this->dispatch('nextStep');
    }

    public function mount(): void
    {
        $this->post = Post::findOrFail($this->postId);

        $this->form->setPost($this->post);
    }

    public function render()
    {
        return view('pages.posts.livewire.steps.compose-post', [
            'canSave' => $this->canSave,
            'canSaveMessage' => $this->canSaveMessage,
        ]);
    }
}
