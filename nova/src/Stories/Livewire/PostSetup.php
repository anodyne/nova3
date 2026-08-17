<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Stories\Actions\UpdatePostAuthors;
use Nova\Stories\Actions\UpdatePostStatus;
use Nova\Stories\Data\PostAuthorsData;
use Nova\Stories\Data\PostStatusData;
use Nova\Stories\Livewire\Concerns\InteractsWithPostType;
use Nova\Stories\Livewire\Concerns\InteractsWithStories;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\States\StoryStatus\Current;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

/**
 * @property-read bool $canContinueWriting
 * @property-read Collection<int, Character>|null $characters
 * @property-read Collection<int, PostType> $availablePostTypes
 * @property-read PostType|null $postType
 * @property-read Collection<int, Story> $currentStories
 * @property-read Story|null $story
 */
class PostSetup extends Component
{
    use InteractsWithPostType;
    use InteractsWithStories;

    public ?int $characterId = null;

    #[Locked]
    public Post $post;

    #[Computed]
    public function canContinueWriting(): bool
    {
        return filled($this->storyId) && filled($this->postTypeId) && filled($this->characterId);
    }

    /**
     * @return Collection<int, Character>|null
     */
    #[Computed]
    public function characters(): ?Collection
    {
        return Auth::user()->activeCharacters;
    }

    public function mount(Post $post): void
    {
        $this->post = $post;

        if ($this->currentStories->count() === 1) {
            $this->storyId = $this->currentStories->first()->id;
        }

        if ($this->availablePostTypes->count() === 1) {
            $this->postTypeId = $this->availablePostTypes->first()->id;
        }

        if ($this->characters->count() === 1) {
            $this->characterId = $this->characters->first()->id;
        }
    }

    public function render(): View
    {
        return view('pages.posts.livewire.post-setup', [
            'availablePostTypes' => $this->availablePostTypes,
            'canContinueWriting' => $this->canContinueWriting,
            'characters' => $this->characters,
            'currentStories' => $this->currentStories,
        ]);
    }

    public function rules(): array
    {
        return [
            'storyId' => [
                'required',
                'exists:stories,id',
                function ($attribute, $value, $fail) {
                    if (! $this->story?->status->equals(Current::class)) {
                        $fail('Please choose a current :attribute to post in.');
                    }
                },
            ],
            'postTypeId' => [
                'required',
                'exists:post_types,id',
                function ($attribute, $value, $fail) {
                    /** @var User */
                    $user = Auth::user();

                    if ($this->postType?->role && ! $user->hasRole($this->postType?->role?->name)) {
                        $fail('Please choose a :attribute that you are authorized to use.');
                    }
                },
            ],
            'characterId' => [
                'required',
                'exists:characters,id',
                function ($attribute, $value, $fail) {
                    if (! Auth::user()->activeCharacters->pluck('id')->contains($value)) {
                        $fail('Please choose a :attribute assigned to your account.');
                    }
                },
            ],
        ];
    }

    public function saveAndContinueWriting(): void
    {
        $this->authorize('write', [$this->post, $this->postType]);

        $this->validate();

        $this->post->post_type_id = $this->postTypeId;
        $this->post->story_id = $this->storyId;

        $this->post->save();

        UpdatePostAuthors::run(
            post: $this->post,
            data: PostAuthorsData::from(
                characters: [
                    $this->characterId => ['user_id' => Auth::id()],
                ],
                users: [],
            ),
            sendNotifications: false
        );

        UpdatePostStatus::run($this->post, PostStatusData::from('draft'));

        $this->redirectRoute('admin.posts.edit', $this->post);
    }

    protected function validationAttributes(): array
    {
        return [
            'storyId' => 'story',
            'postTypeId' => 'post type',
            'characterId' => 'character',
        ];
    }
}
