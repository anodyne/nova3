<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Database\Eloquent\Collection as DatabaseCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Nova\Characters\Models\Character;
use Nova\Stories\Models\PostAuthor;
use Nova\Users\Models\User;

/**
 * @phpstan-type CharacterAuthor array{
 *     id: int,
 *     name: string,
 *     type: string,
 *     avatar_url: string,
 *     activeUsers: array<int, array<string, mixed>>,
 *     pivot: array{
 *         user: mixed,
 *         user_id: int|string|null
 *     }
 * }
 * @phpstan-type CharacterAuthorPivotData array{user_id: int|string|null}
 */
trait InteractsWithCharacterAuthors
{
    /** @var array<int, CharacterAuthor> */
    public array $characterAuthorsArr = [];

    /** @var array<int, CharacterAuthorPivotData> */
    public array $characterAuthorsPivotData = [];

    /** @var array<int, int> */
    public array $characterAuthorsValidationErrors = [];

    public function addCharacterAuthor(int $characterId): void
    {
        if (! $this->characterAuthors()->contains('id', $characterId)) {
            $character = Character::query()->with('activeUsers')->find($characterId);

            if ($character) {
                $numberOfActiveUsers = $character->activeUsers->count();

                $userId = $numberOfActiveUsers === 1
                    ? $character->activeUsers->first()->id
                    : null;

                $updatedCharacterAuthorsArr = [
                    ...$this->characterAuthorsArr,
                    $this->characterArrayStructure($character, $userId),
                ];

                $this->characterAuthorsArr = $updatedCharacterAuthorsArr;

                if ($numberOfActiveUsers > 1) {
                    $this->addCharacterAuthorValidationError($character->id);
                }
            }

            $this->syncCharacterAuthorsPivotData();

            $this->dispatch('dropdown-close');
        }
    }

    /** @return Collection<int, object> */
    public function characterAuthors(): Collection
    {
        return collect($this->characterAuthorsArr)
            ->map(fn ($character): object => $this->characterObjectStructure($character));
    }

    public function removeCharacterAuthor(int $characterId): void
    {
        $this->dispatch('dropdown-close');

        $this->characterAuthorsArr = Arr::reject($this->characterAuthorsArr, fn ($character): bool => $character['id'] === $characterId);

        unset($this->characterAuthorsPivotData[$characterId]);

        $this->removeCharacterAuthorValidationErrors($characterId);
    }

    /** @param array<int, CharacterAuthor>|DatabaseCollection<int, Character> $characterAuthors */
    public function setCharacterAuthors(array|DatabaseCollection $characterAuthors): void
    {
        if (is_array($characterAuthors)) {
            $this->characterAuthorsArr = $characterAuthors;
        } else {
            $this->characterAuthorsArr = $characterAuthors
                ->map(fn (Character $character): array => $this->characterArrayStructure($character))
                ->toArray();
        }

        $this->syncCharacterAuthorsPivotData();
    }

    public function updatedCharacterAuthorsPivotData(mixed $value, string $property): void
    {
        $id = str($property)->before('.user_id')->toInteger();

        $this->characterAuthorsArr = array_map(function (array $character) use ($id, $value): array {
            if ($character['id'] === $id) {
                $character['pivot'] = [
                    'user' => User::find($value),
                    'user_id' => $value,
                ];

                if (filled($value)) {
                    $this->removeCharacterAuthorValidationErrors($id);
                } else {
                    $this->addCharacterAuthorValidationError($id);
                }
            }

            return $character;
        }, $this->characterAuthorsArr);
    }

    private function addCharacterAuthorValidationError(int $id): void
    {
        $this->characterAuthorsValidationErrors[$id] = $id;
    }

    /** @return CharacterAuthor */
    private function characterArrayStructure(Character $character, ?int $pivotUserId = null): array
    {
        $authorship = $character->relationLoaded('pivot')
            ? $character->getRelation('pivot')
            : null;

        $pivotArray = $authorship instanceof PostAuthor
            ? [
                'user' => $authorship->user,
                'user_id' => $authorship->user_id,
            ]
            : [
                'user' => User::find($pivotUserId),
                'user_id' => $pivotUserId,
            ];

        return [
            'id' => $character->id,
            'name' => $character->display_name,
            'type' => $character->type->value,
            'avatar_url' => $character->avatar_url,
            'activeUsers' => $character->activeUsers->map(fn (User $user) => $user->toArray())->toArray(),
            'pivot' => $pivotArray,
        ];
    }

    /** @param CharacterAuthor $character */
    private function characterObjectStructure(array $character): object
    {
        return (object) [
            'id' => data_get($character, 'id'),
            'name' => data_get($character, 'name'),
            'type' => data_get($character, 'type'),
            'avatar_url' => data_get($character, 'avatar_url'),
            'activeUsers' => collect($character['activeUsers'])->map(fn (array $user): object => (object) $user),
            'pivot' => (object) [
                'user' => (object) data_get($character, 'pivot.user'),
                'user_id' => data_get($character, 'pivot.user_id'),
            ],
        ];
    }

    private function removeCharacterAuthorValidationErrors(int $id): void
    {
        if (array_key_exists($id, $this->characterAuthorsValidationErrors)) {
            unset($this->characterAuthorsValidationErrors[$id]);
        }
    }

    private function setAuthorUserId(int $characterId, ?int $userId): void
    {
        $character = $this->characterAuthors()->firstWhere('id', $characterId);

        if ($character) {
            $this->characterAuthorsPivotData[$characterId] = ['user_id' => $userId];
        }
    }

    private function syncCharacterAuthorsPivotData(): void
    {
        $this->characterAuthorsPivotData = collect($this->characterAuthorsArr)
            ->mapWithKeys(fn ($character): array => [
                $character['id'] => [
                    'user_id' => data_get($character, 'pivot.user_id'),
                ],
            ])
            ->toArray();
    }
}
