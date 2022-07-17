<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Steps;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Redirector;
use Nova\Posts\Livewire\Concerns\HasPost;
use Nova\Posts\Livewire\Concerns\HasPostType;
use Nova\Posts\Livewire\Concerns\HasStory;
use Nova\Posts\Livewire\Concerns\SetsPostPosition;
use Nova\Posts\Models\States\Published;
use Nova\Users\Models\User;
use Spatie\LivewireWizard\Components\StepComponent;

class PublishPostStep extends StepComponent
{
    use HasPost;
    use HasPostType;
    use HasStory;
    use SetsPostPosition;

    public $participatingUsers;

    protected $listeners = [
        'selectedPostPosition',
        'refreshParticipatingUsers',
    ];

    public function stepInfo(): array
    {
        return [
            'label' => 'Publish post',
        ];
    }

    public function publish(): Redirector
    {
        if (! $this->post->status->equals(Published::class)) {
            $this->post->status->transitionTo(Published::class);
        }

        return redirect()->route('writing-overview')
            ->withToast($this->post->title . ' has been published');
    }

    public function removeParticipant(User $user): void
    {
        $this->dispatchBrowserEvent('dropdown-close');
        
        $this->post->removeParticipant($user);

        $this->refreshParticipatingUsers();
    }

    public function refreshParticipatingUsers(): void
    {
        $this->participatingUsers = $this->post->fresh()->participatingUsers;
    }

    public function booted(): void
    {
        $this->participatingUsers = $this->post->participatingUsers;
    }

    public function render()
    {
        return view('livewire.posts.steps.publish-post');
    }
}
