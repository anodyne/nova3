<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Nova\Characters\Models\Character;

trait HandlesCharacterAuthors
{
    public Collection $characterAuthors;

    public array $characterAuthorPivotData = [];

    public array $characterAuthorValidationErrors = [];

    // public function mountHandlesCharacterAuthors(): void
    // {
    //     $this->characterAuthors = $this->characterAuthors ?? new Collection;

    //     $this->reloadCharacterAuthorRelationships();

    //     $this->syncCharacterAuthorPivotData($this->post?->id);
    // }

    // public function hydrateHandlesCharacterAuthors(): void
    // {
    //     $this->characterAuthors = Character::whereIn('id', collect($this->characterAuthors)->pluck('id'))
    //         ->with(['activeUsers', 'postAuthors' => fn (Builder $query) => $query->where('post_id', $this->post->id)])
    //         ->get();

    //     $this->syncCharacterAuthorPivotData($this->post?->id);
    // }

    public function addCharacterAuthor(int $characterId): void
    {
        if (! $this->characterAuthors->contains('id', $characterId)) {
            $character = Character::query()
                ->with([
                    'activeUsers',
                    'postAuthors' => fn (Builder $query) => $query->select(['id', 'user_id', 'authorable_id', 'authorable_type']),
                ])
                ->find($characterId);

            if ($character) {
                $userId = $character->relationLoaded('activeUsers') && $character->activeUsers->count() === 1
                    ? $character->activeUsers->first()->id
                    : null;

                $this->characterAuthors->push($character);

                $this->setAuthorUserId($characterId, $userId);
            }

            $this->syncCharacterAuthorPivotData($this->post?->id);
        }
    }

    public function removeCharacterAuthor(int $characterId): void
    {
        $this->characterAuthors = $this->characterAuthors->reject(fn (Character $characterAuthor) => $characterAuthor->id === $characterId);

        unset($this->characterAuthorPivotData[$characterId], $this->characterAuthorValidationErrors[$characterId]);
    }

    public function setAuthorUserId(int $characterId, ?int $userId): void
    {
        $character = $this->characterAuthors->firstWhere('id', $characterId);

        if ($character) {
            $this->characterAuthorPivotData[$characterId] = ['user_id' => $userId];
        }

        $this->syncCharacterAuthorPivotData($this->post?->id);
    }

    public function validateCharacterAuthors(): void
    {
        $this->characterAuthorValidationErrors = [];

        foreach ($this->characterAuthors->loadMissing('activeUsers') as $character) {
            $activeUsers = $character->activeUsers->pluck('id')->toArray();
            $userId = $this->characterAuthorPivotData[$character->id]['user_id'] ?? null;

            if (count($activeUsers) > 1 && ! $userId) {
                $this->characterAuthorValidationErrors[$character->id] = 'Character with multiple active users must have a user selected.';
            } elseif (count($activeUsers) === 0 && ! $userId) {
                $this->characterAuthorValidationErrors[$character->id] = 'Character without active users must have a user selected from available users.';
            }
        }
    }

    public function syncCharacterAuthorPivotData(int $postId): void
    {
        if ($this->characterAuthors->isNotEmpty()) {
            $this->characterAuthorPivotData = $this->characterAuthors->mapWithKeys(function (Character $character) use ($postId) {
                $postAuthor = $character->postAuthors->where('post_id', $postId)->first();

                return [
                    $character->id => [
                        'user_id' => $postAuthor?->pivot['user_id'] ?? null,
                        'authorable_type' => $postAuthor?->pivot['authorable_type'] ?? null,
                    ],
                ];
            })->toArray();
        }

        $this->validateCharacterAuthors();
    }

    #[On('characterAuthorsChanged')]
    public function handleCharacterAuthorsChanged($newAuthors): void
    {
        $this->characterAuthors = new Collection($newAuthors);

        $this->reloadCharacterAuthorRelationships();

        $this->syncCharacterAuthorPivotData($this->post?->id);
    }

    private function reloadCharacterAuthorRelationships(): void
    {
        if ($this->characterAuthors->isNotEmpty()) {
            $postId = $this->post->id;

            $this->characterAuthors = Character::query()
                ->whereIn('id', $this->characterAuthors->pluck('id'))
                ->with([
                    'activeUsers',
                    'postAuthors' => function (Builder $query) use ($postId) {
                        $query->where('post_id', $postId) // ✅ Ensure only one post is loaded
                            ->select([
                                'posts.id as post_id',
                                'posts.title',
                                'posts.post_type_id',
                                'posts.story_id',
                                'post_author.user_id',
                                'post_author.authorable_id',
                                'post_author.authorable_type',
                            ]);
                    },
                ])
                ->get();
        }
    }
}
