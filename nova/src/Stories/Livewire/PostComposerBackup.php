<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Carbon\CarbonInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Actions\LockPost;
use Nova\Stories\Actions\UnlockPost;
use Nova\Stories\Actions\UpdateContributorWordCount;
use Nova\Stories\Actions\UpdatePost;
use Nova\Stories\Actions\UpdatePostAuthors;
use Nova\Stories\Actions\UpdatePostStatus;
use Nova\Stories\Data\PostAuthorsData;
use Nova\Stories\Data\PostData;
use Nova\Stories\Data\PostStatusData;
use Nova\Stories\Enums\ContentRatingValue;
use Nova\Stories\Livewire\Concerns\HandlesCharacterAuthors;
use Nova\Stories\Livewire\Concerns\HandlesUserAuthors;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\States\PostStatus\Published;
use Nova\Stories\Models\Story;
use Nova\Stories\Notifications\PostSaved;
use Nova\Users\Models\User;

class PostComposerBackup extends Component
{
    use HandlesCharacterAuthors;
    use HandlesUserAuthors;

    public Post $post;

    public ?CarbonInterface $lastUpdate = null;

    #[Validate]
    public ?string $title = null;

    #[Validate]
    public ?string $content = null;

    #[Validate]
    public ?string $location = null;

    #[Validate]
    public ?string $day = null;

    #[Validate]
    public ?string $time = null;

    public ?int $post_type_id = null;

    public ?int $story_id = null;

    public ContentRatingValue $rating_language;

    public ContentRatingValue $rating_sex;

    public ContentRatingValue $rating_violence;

    #[Validate]
    public ?string $summary = null;

    /**
     * When Livewire updates a property, do some checks:
     *
     * For a post that hasn't been persisted to the database:
     *   Post type and story should check that the setup fields are updated
     *
     * For a post that has been persisted to the database:
     *
     * For all properties, update the last update timestamp for tracking dirty status
     */
    public function updated($property)
    {
        if (! $this->post->exists) {
            match ($property) {
                'post_type_id' => $this->setupFieldsUpdated(),
                'story_id' => $this->setupFieldsUpdated(),
                default => null,
            };
        }

        $this->lastUpdate = Date::now();
    }

    public function postTypeUpdated(): void
    {
        $this->day = null;
        $this->time = null;
        $this->location = null;

        // TODO: handle authors when a post type changes
        // TODO: handle rating when a post type changes

        $this->setupFieldsUpdated();
    }

    public function setupFieldsUpdated(): void
    {
        $this->post->post_type_id = $this->post_type_id;
        $this->post->story_id = $this->story_id;

        if (filled($this->story_id) && filled($this->post_type_id) && count($this->selectedCharacters) > 0) {
            $redirect = $this->post->exists ? false : true;

            if (! $this->post->exists) {
                $this->post->save();
            }

            $this->save(quiet: true);

            UpdatePostStatus::run($this->post, PostStatusData::from('draft'));

            if ($redirect) {
                to_route('admin.posts.edit', $this->post->id);
            }
        }
    }

    public function setupAuthorForNewPost(Character $character): void
    {
        if (! $this->post->exists) {
            $this->addCharacterAuthor($character);

            $this->setupFieldsUpdated();
        }
    }

    #[Computed]
    public function postSetupComplete(): bool
    {
        return filled($this->post_type_id) && filled($this->story_id) && filled($this->characterAuthors);
    }

    #[Computed]
    public function postIsDirty(): bool
    {
        return filled($this->lastUpdate);
    }

    #[Computed]
    public function postType(): ?PostType
    {
        return PostType::find($this->post_type_id);
    }

    #[Computed]
    public function story(): ?Story
    {
        return Story::find($this->story_id);
    }

    #[Computed]
    public function availablePostTypes(): Collection
    {
        return PostType::query()
            ->with('role')
            ->withTrashed()
            ->where(function (Builder $query): Builder {
                return $query->active()
                    ->userHasAccess(Auth::user()->loadMissing('roles'))
                    ->orWhere('id', $this->post_type_id);
            })
            ->ordered()
            ->get();
    }

    #[Computed]
    public function currentStories(): Collection
    {
        return Story::query()
            ->where(function (Builder $query): Builder {
                return $query->current()->orWhere('id', $this->story_id);
            })
            ->get();
    }

    #[Computed]
    public function myCharacters(): ?Collection
    {
        return Auth::user()->activeCharacters;
    }

    public function save(bool $quiet = false): void
    {
        $oldPostWordCount = $this->post->word_count;

        $post = UpdatePost::run($this->post, PostData::from($this->all()));

        $post = UpdateContributorWordCount::run(
            post: $this->post,
            user: $user = Auth::user(),
            oldWordCount: $oldPostWordCount,
        );

        $post = UpdatePostAuthors::run(
            $post,
            PostAuthorsData::from(
                characters: $this->selectedCharacters,
                users: $this->selectedUsers
            )
        );

        $this->post = $post->loadMissing(['characterAuthors.activeUsers', 'userAuthors']);

        $this->post->addParticipant($user);

        $this->post->participatingUsers
            ->filter(fn (User $user) => $user->id !== Auth::id())
            ->each->notify(new PostSaved($this->post, $user));

        $this->lastUpdate = null;

        if (! $quiet) {
            Notification::make()->success()
                ->title('Post saved')
                ->send();
        }
    }

    public function checkLock(): void
    {
        if ($this->post?->exists) {
            if ($this->post->isLocked() && $this->lastUpdate->gte($this->post->locked_at)) {
                LockPost::run($this->post, Auth::user());
            } else {
                UnlockPost::run($this->post, Auth::user());

                to_route('admin.writing-overview');
            }
        }
    }

    public function rules()
    {
        if (! $this->post->exists) {
            return ['title' => 'nullable'];
        }

        return $this->postType->fields
            ->enabledFields()
            ->filter(fn ($item, $key) => in_array($key, ['title', 'location', 'day', 'time', 'content']))
            ->mapWithKeys(fn ($item, $key) => [$key => $item->required ? 'required' : 'nullable'])
            ->all();
    }

    public function mount()
    {
        if (is_null($postId = request()->route()->originalParameter('post'))) {
            $this->mountForPostCreation();
        } else {
            $this->mountForPostEditing((int) $postId);
        }
    }

    public function render()
    {
        if ($this->post->isLocked() && ! $this->post->lockIsOwnedBy(Auth::user())) {
            return view('pages.posts.livewire.steps.post-locked');
        }

        return view('pages.posts.livewire.post-composer', [
            'availablePostTypes' => $this->availablePostTypes,
            'currentStories' => $this->currentStories,
            'myCharacters' => $this->myCharacters,
            'postIsDirty' => $this->postIsDirty,
            'postSetupComplete' => $this->postSetupComplete,
            'postType' => $this->postType,
            'story' => $this->story,
            'previousPost' => $this->previousPost,
            'nextPost' => $this->nextPost,
        ]);
    }

    #[Computed]
    public function previousPost(): ?Post
    {
        if (! $this->post->exists) {
            return null;
        }

        return $this->post->previousSibling(Published::class);
    }

    #[Computed]
    public function nextPost(): ?Post
    {
        if (! $this->post->exists) {
            return null;
        }

        return $this->post->nextSibling(Published::class);
    }

    /**
     * When a user lands on the post create page, the following steps happen:
     *
     * 1 - Create a new post object
     *
     * 2 - Load attributes into the Livewire component (all null except for authors and ratings)
     *
     * 3a - If there is only 1 available post type, set that for the post
     * 3b - If there is only 1 current story, set that for the post
     * 3c - If the user only has 1 active character, set that for the post
     *
     * 4 - Check for the setup fields (post type, story, author) being ready to go
     * 4a - If it is ready to go:
     *   Save the post record to the database
     *   Update the post with the author relationships
     *   Transition the post from started to draft
     * 4b - If it isn't ready to go:
     *   Show the setup page or do nothing if the user is already there
     *
     * 5 - On the setup page:
     *   When the post type field is updated, go to 4
     *   When the story field is updated, go to 4
     *   When the author field is updated, go to 4
     */
    protected function mountForPostCreation(): void
    {
        $this->post = new Post;

        $this->loadPostAttributes();

        if (blank($this->post_type_id) && $this->availablePostTypes->count() === 1) {
            $this->post_type_id = $this->availablePostTypes->first()->id;
        }

        if (blank($this->story_id) && $this->currentStories->count() === 1) {
            $this->story_id = $this->currentStories->first()->id;
        }

        if (blank($this->characters) && $this->myCharacters->count() === 1) {
            $this->addCharacterAuthor($this->myCharacters->first()->id);
        }

        $this->setupFieldsUpdated();
    }

    /**
     * When a user lands on the post edit page, the following steps happen:
     *
     * 1 - Retrieve the post from the database based on the ID in the URL
     *
     * 2 - Load attributes into the Livewire component from the loaded post
     */
    protected function mountForPostEditing(int $postId): void
    {
        $this->post = Post::with(['characterAuthors.activeUsers', 'userAuthors'])->find($postId);

        if (! $this->post->isLocked() || ($this->post->isLocked() && $this->post->lockIsOwnedBy(Auth::user()))) {
            $this->loadPostAttributes();

            LockPost::run($this->post, Auth::user());
        }
    }

    protected function loadPostAttributes(): void
    {
        logger('loading post attributes');

        $this->post_type_id = $this->post?->post_type_id;
        $this->story_id = $this->post?->story_id;

        $this->title = $this->post?->title;
        $this->location = $this->post?->location;
        $this->day = $this->post?->day;
        $this->time = $this->post?->time;

        $this->summary = $this->post?->summary;

        $this->content = $this->post?->content ?? '<p></p>';

        $this->rating_language = $this->post?->rating_language ?? settings('ratings.language.rating');
        $this->rating_sex = $this->post?->rating_sex ?? settings('ratings.sex.rating');
        $this->rating_violence = $this->post?->rating_violence ?? settings('ratings.violence.rating');

        $this->characterAuthors = $this->post?->characterAuthors ?? Collection::make();
        $this->users = $this->post?->userAuthors ?? Collection::make();
    }
}
