<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Steps;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Posts\Livewire\Concerns\HandlesCharacterAuthors;
use Nova\Posts\Livewire\Concerns\HandlesUserAuthors;
use Nova\Posts\Livewire\Concerns\HasParentState;
use Nova\Posts\Livewire\Concerns\InteractsWithRoute;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\PostAuthor;
use Nova\Posts\Notifications\CharacterAuthorAddedToPost;
use Nova\Posts\Notifications\CharacterAuthorRemovedFromPost;
use Nova\Posts\Notifications\UserAuthorAddedToPost;
use Nova\Posts\Notifications\UserAuthorRemovedFromPost;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;

class SetupPostStep extends WizardStep
{
    use HandlesCharacterAuthors;
    use HandlesUserAuthors;
    use HasParentState;
    use InteractsWithRoute;

    public ?int $postTypeId = null;

    public ?int $storyId = null;

    public ?Post $post = null;

    public string $search = '';

    public function stepInfo(): array
    {
        return [
            'label' => 'Setup your post',
        ];
    }

    #[Computed]
    public function canGoToNextStep(): bool
    {
        return filled($this->story) &&
            filled($this->postType) &&
            ($this->characters->count() > 0 || $this->users->count() > 0) &&
            count($this->validateSelectedCharacters) === 0;
    }

    #[Computed]
    public function canGoToNextStepMessage(): string
    {
        $fields = Arr::build([
            'a story' => blank($this->story),
            'a post type' => blank($this->postType),
            'an author' => $hasAuthors = $this->characters->count() === 0 && $this->users->count() === 0,
            'a user for all played characters' => $hasAuthors && count($this->validateSelectedCharacters) > 0,
        ]);

        // $fields = [];

        // if (blank($this->story)) {
        //     $fields[] = 'a story';
        // }

        // if (blank($this->postType)) {
        //     $fields[] = 'a post type';
        // }

        // if ($this->characters->count() === 0 && $this->users->count() === 0) {
        //     $fields[] = 'an author';
        // } else {
        //     if (count($this->validateSelectedCharacters) > 0) {
        //         $fields[] = 'a user for all played characters';
        //     }
        // }

        return sprintf(
            'Please select %s to continue',
            Arr::join(
                $fields,
                count($fields) >= 3 ? ', ' : ' and ',
                count($fields) >= 3 ? ', and ' : ''
            )
        );
    }

    public function goToNextStep(): void
    {
        $this->saveQuietly();

        $this->dispatch('refreshPost', $this->post->id);

        $this->dispatch('nextStep');
    }

    public function save(bool $quiet = false): void
    {
        $sendAuthorNotifications = $this->post->exists;

        $originalPostParticipants = PostAuthor::post($this->post->id)->get();

        $this->post->post_type_id = $this->postTypeId;
        $this->post->story_id = $this->storyId;

        $route = $this->getCurrentRoute();

        if ($route->hasParameter('neighbor')) {
            $this->post->neighbor = $route->parameter('neighbor');
            $this->post->direction = $route->parameter('direction', 'after');
        }

        $this->post->save();

        $this->post->characterAuthors()->sync($this->selectedCharacters);
        $this->post->userAuthors()->sync($this->selectedUsers);

        if ($sendAuthorNotifications) {
            $this->post->refresh();

            $this->sendNotificationsToAddedAuthors(
                original: $originalPostParticipants,
                new: $newPostParticipants = PostAuthor::post($this->post->id)->get()
            );

            $this->sendNotificationsToRemovedAuthors(
                original: $originalPostParticipants,
                new: $newPostParticipants
            );
        }

        if (! $quiet) {
            Notification::make()->success()
                ->title(($this->post->title ?? $this->postType->name).' has been saved')
                ->send();
        }
    }

    public function saveQuietly(): void
    {
        $this->save(quiet: true);
    }

    public function updated($property, $value)
    {
        $propertyStr = str($property);

        if ($propertyStr->startsWith('selectedCharacters')) {
            [, $characterId] = explode('.', $property);

            if (filled($value)) {
                unset($this->validateSelectedCharacters[$characterId]);
            } else {
                $this->validateSelectedCharacters[$characterId] = $characterId;
            }
        }
    }

    #[Computed]
    public function currentStories(): Collection
    {
        return Story::query()
            ->where(function (Builder $query): Builder {
                return $query->current()->orWhere('id', $this->storyId);
            })
            ->get();
    }

    public function updatedStoryId(): void
    {
        if ($this->currentStories->contains('id', $this->storyId)) {
            $this->dispatch('selectedStory', $this->storyId);
        } else {
            Notification::make()->danger()
                ->title('Story was not updated')
                ->body('You chose an invalid story. Please choose a story from the dropdown.')
                ->send();

            $this->storyId = $this->post?->story_id;
        }
    }

    #[Computed]
    public function availablePostTypes(): Collection
    {
        return PostType::with('role')
            ->withTrashed()
            ->where(function (Builder $query): Builder {
                return $query->active()
                    ->userHasAccess(auth()->user()->loadMissing('roles'))
                    ->orWhere('id', $this->postTypeId);
            })
            ->ordered()
            ->get();
    }

    public function updatedPostTypeId(): void
    {
        if ($this->availablePostTypes->contains('id', $this->postTypeId)) {
            $this->dispatch('selectedPostType', $this->postTypeId);
        } else {
            Notification::make()->danger()
                ->title('Post type was not updated')
                ->body('You chose an invalid post type. Please choose a post type from the dropdown.')
                ->send();

            $this->postTypeId = $this->post?->post_type_id;
        }
    }

    #[Computed]
    public function canAddAuthors(): bool
    {
        if ($this->postType?->options?->allowsMultipleAuthors) {
            return true;
        }

        if ($this->characters->count() > 0 || $this->users->count() > 0) {
            return false;
        }

        return true;
    }

    #[Computed]
    public function authorSearchPlaceholder(): string
    {
        $options = $this->postType?->options;

        return match (true) {
            $options?->allowsCharacterAuthors && ! $options?->allowsUserAuthors => 'Find a character to add as an author',
            ! $options?->allowsCharacterAuthors && $options?->allowsUserAuthors => 'Find a user to add as an author',
            default => 'Find a character or user to add as an author',
        };
    }

    public function mount(): void
    {
        $this->postTypeId = $this->postType?->id;
        $this->storyId = $this->story?->id;

        if (blank($this->postTypeId) && $this->availablePostTypes->count() === 1) {
            $this->postTypeId = $this->availablePostTypes->first()->id;

            $this->updatedPostTypeId();
        }

        if (blank($this->storyId) && $this->currentStories->count() === 1) {
            $this->storyId = $this->currentStories->first()->id;

            $this->updatedStoryId();
        }

        $this->post = Post::firstOrNew(['id' => $this->postId])->loadMissing('characterAuthors', 'userAuthors');

        $this->characters = $this->post?->characterAuthors ?? Collection::make();
        $this->users = $this->post?->userAuthors ?? Collection::make();
    }

    public function render()
    {
        return view('pages.posts.livewire.steps.setup-post', [
            'allUsers' => $this->allUsers,
            'authorSearchPlaceholder' => $this->authorSearchPlaceholder,
            'availablePostTypes' => $this->availablePostTypes,
            'canAddAuthors' => $this->canAddAuthors,
            'canGoToNextStep' => $this->canGoToNextStep,
            'canGoToNextStepMessage' => $this->canGoToNextStepMessage,
            'currentStories' => $this->currentStories,
            'filteredCharacters' => $this->filteredCharacters,
            'filteredUsers' => $this->filteredUsers,
        ]);
    }

    protected function sendNotificationsToAddedAuthors(Collection $original, Collection $new): void
    {
        $new->diff($original)->each(
            fn (PostAuthor $participant) => match ($participant->authorable_type) {
                'character' => $participant->user->notify(
                    new CharacterAuthorAddedToPost($this->post, $participant->character)
                ),

                'user' => $participant->user->notify(new UserAuthorAddedToPost($this->post)),

                default => null,
            }
        );
    }

    protected function sendNotificationsToRemovedAuthors(Collection $original, Collection $new): void
    {
        $original->diff($new)->each(
            fn (PostAuthor $participant) => match ($participant->authorable_type) {
                'character' => $participant->user->notify(
                    new CharacterAuthorRemovedFromPost($this->post, $participant->character)
                ),

                'user' => $participant->user->notify(new UserAuthorRemovedFromPost($this->post)),

                default => null,
            }
        );
    }
}
