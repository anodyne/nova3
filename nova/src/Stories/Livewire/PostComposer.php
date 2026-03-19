<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Carbon\CarbonInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Actions\DeletePost;
use Nova\Stories\Actions\DiscardPost;
use Nova\Stories\Actions\UnlockPost;
use Nova\Stories\Data\Field;
use Nova\Stories\Enums\PostTypeField;
use Nova\Stories\Livewire\Concerns\InteractsWithPostLocks;
use Nova\Stories\Livewire\Concerns\InteractsWithPostType;
use Nova\Stories\Livewire\Concerns\InteractsWithStories;
use Nova\Stories\Models\Post;
use Nova\Stories\Notifications\PostSaved;
use Nova\Users\Models\User;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class PostComposer extends Component
{
    use InteractsWithConfirmationModal;
    use InteractsWithPostLocks;
    use InteractsWithPostType;
    use InteractsWithStories;

    #[Locked]
    public Post $post;

    public ?CarbonInterface $lastUpdate = null;

    public int $savedChildrenCount = 0;

    public bool $saveSilently = false;

    public ?string $validationErrors = null;

    public function delete(): void
    {
        $this->authorize('delete', $this->post);

        $this->askForConfirmation(
            callback: function () {
                DeletePost::run($this->post);

                Notification::make()->success()
                    ->title('Post was deleted')
                    ->send();

                $this->redirectRoute('admin.writing-overview');
            },
            prompt: [
                'title' => 'Delete post?',
                'message' => __('messages.delete-post'),
                'confirm' => 'Yes, delete',
                'cancel' => 'Cancel',
            ],
            confirmPhrase: 'DELETE',
            theme: 'danger',
        );
    }

    public function discard(): void
    {
        $this->authorize('discard', $this->post);

        $this->askForConfirmation(
            callback: function (): void {
                DiscardPost::run($this->post);

                Notification::make()->success()
                    ->title($this->postType->name.' draft has been discarded')
                    ->send();

                $this->redirectRoute('admin.writing-overview');
            },
            prompt: [
                'title' => 'Discard draft?',
                'message' => __('messages.discard-post-draft', [
                    'type' => str($this->postType->name)->lower()->toString(),
                ]),
                'confirm' => 'Yes, discard',
                'cancel' => 'Cancel',
            ],
            confirmPhrase: 'DISCARD',
            theme: 'danger',
        );
    }

    public function handleUpdateFromChild(): void
    {
        $this->lastUpdate = now();
    }

    public function openForPublishing(): void
    {
        $this->save(silently: true);

        $this->dispatch(
            'slide-over.open',
            PostPublish::class,
            ['postId' => $this->post->id]
        );
    }

    public function save(bool $silently = false): void
    {
        $this->saveSilently = $silently;

        $this->savedChildrenCount = 0;

        foreach ($this->childrenComponents() as $component) {
            $this->dispatch('save-post')->to($component);
        }

        $this->lastUpdate = null;
    }

    public function saveAndFinish(bool $silently = false): void
    {
        $this->save($silently);

        UnlockPost::run($this->post, Auth::user());

        Notification::make()->success()
            ->title('Post unlocked')
            ->body('Your post has been saved and unlocked for editing by other authors.')
            ->send();

        $this->redirectRoute('admin.writing-overview');
    }

    public function mount(?Post $post = null): void
    {
        $this->post = $post->loadMissing([
            'characterAuthors.activeUsers',
            'participatingUsers',
            'postType',
            'story',
            'userAuthors',
        ]);

        $this->postTypeId = $post->post_type_id;
        $this->storyId = $post->story_id;

        $this->authorize('write', [$this->post, $this->postType]);

        $this->lockPost();
    }

    public function render(): View
    {
        if ($this->postIsLocked) {
            return view('pages.posts.livewire.post-locked');
        }

        return view('pages.posts.livewire.post-composer', [
            'availablePostTypes' => $this->availablePostTypes,
            'canPublish' => $this->canPublish,
            'currentStories' => $this->currentStories,
            'postIsDirty' => $this->isDirty,
            'postType' => $this->postType,
            'story' => $this->story,
            'shouldUsePostLock' => $this->shouldUsePostLock,
        ]);
    }

    public function rules()
    {
        return $this->postType->fields
            ->enabledFields()
            ->mapWithKeys(function (Field $field, string $key): array {
                $fieldInfo = PostTypeField::tryFrom($key);

                return ["post.$key" => $field->required ? $fieldInfo->requiredValidationRule() : 'nullable'];
            })
            ->toArray();
    }

    #[Computed]
    public function canPublish(): bool
    {
        try {
            $this->validate();

            $this->validationErrors = null;

            return true;
        } catch (ValidationException $th) {
            $fields = collect($th->errors())
                ->keys()
                ->flatMap(fn (string $key) => [str($key)->after('post.')->toString()])
                ->join(', ', ' and ');

            $message = __('messages.post-validation-errors', [
                'type' => str($this->postType->name)->lower()->toString(),
                'fields' => $fields,
            ]);

            $this->validationErrors = str($message)->inlineMarkdown()->toString();

            return false;
        }
    }

    #[Computed]
    public function isDirty(): bool
    {
        return $this->lastUpdate !== null;
    }

    #[On('save-post-completed')]
    public function checkAllSaved(): void
    {
        $this->savedChildrenCount++;

        $totalChildren = count($this->childrenComponents());

        if ($this->savedChildrenCount === $totalChildren) {
            if (! $this->saveSilently) {
                $this->post->participatingUsers
                    ->filter(fn (User $user): bool => $user->id !== Auth::id())
                    ->each->notify(new PostSaved($this->post, Auth::user()));

                Notification::make()->success()
                    ->title('Post saved')
                    ->send();
            }

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

        if ($this->post?->postType?->fields?->summary?->enabled) {
            $components[] = PostSummary::class;
        }

        $components[] = PostPosition::class;

        return $components;
    }
}
