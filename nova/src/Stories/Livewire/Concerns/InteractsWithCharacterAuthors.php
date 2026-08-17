<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Database\Eloquent\Collection as DatabaseCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Nova\Characters\Models\Character;
use Nova\Stories\Models\PostAuthor;
use Nova\Users\Models\User;

trait InteractsWithCharacterAuthors
{
    public array $characterAuthorsArr = [];

    public array $characterAuthorsPivotData = [];

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

    public function characterAuthors(): Collection
    {
        return collect($this->characterAuthorsArr)
            ->map(fn ($character): object => $this->characterObjectStructure($character));
    }

    public function removeCharacterAuthor(int $characterId): void
    {
        $this->dispatch('dropdown-close');

        $this->characterAuthorsArr = Arr::reject($this->characterAuthorsArr, fn ($character) => $character['id'] === $characterId);

        unset($this->characterAuthorsPivotData[$characterId]);

        $this->removeCharacterAuthorValidationErrors($characterId);
    }

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

    public function updatedCharacterAuthorsPivotData($value, $property)
    {
        $id = str($property)->before('.user_id')->toInteger();

        $this->characterAuthorsArr = array_map(function ($character) use ($id, $value) {
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

    private function characterArrayStructure(Character $character, ?int $pivotUserId = null): array
    {
        $authorship = $character->relationLoaded('authorship')
            ? $character->getRelation('authorship')
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

    private function characterObjectStructure(array $character): object
    {
        return (object) [
            'id' => data_get($character, 'id'),
            'name' => data_get($character, 'name'),
            'type' => data_get($character, 'type'),
            'avatar_url' => data_get($character, 'avatar_url'),
            'activeUsers' => collect($character['activeUsers'])->map(fn (User $user) => $user),
            'pivot' => (object) [
                'user' => (object) data_get($character, 'authorship.user'),
                'user_id' => data_get($character, 'authorship.user_id'),
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
                    'user_id' => data_get($character, 'authorship.user_id'),
                ],
            ])
            ->toArray();
    }
}
