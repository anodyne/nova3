<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Database\Eloquent\Collection as DatabaseCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Nova\Users\Models\User;

trait InteractsWithUserAuthors
{
    public array $userAuthorsArr = [];

    public array $userAuthorsPivotData = [];

    public function addUserAuthor(int $userId): void
    {
        if (! $this->userAuthors()->contains('id', $userId)) {
            $user = User::find($userId);

            if ($user) {
                $updatedUserAuthorsArr = [
                    ...$this->userAuthorsArr,
                    $this->userArrayStructure($user, $userId),
                ];

                $this->userAuthorsArr = $updatedUserAuthorsArr;
            }

            $this->syncUserAuthorsPivotData();

            $this->dispatch('dropdown-close');
        }
    }

    public function removeUserAuthor(int $userId): void
    {
        $this->dispatch('dropdown-close');

        $this->userAuthorsArr = Arr::reject($this->userAuthorsArr, fn ($user) => $user['id'] === $userId);

        unset($this->userAuthorsPivotData[$userId]);
    }

    public function setUserAuthors(array|DatabaseCollection $userAuthors): void
    {
        if (is_array($userAuthors)) {
            $this->userAuthorsArr = $userAuthors;
        } else {
            $this->userAuthorsArr = $userAuthors
                ->map(fn (User $user): array => $this->userArrayStructure($user))
                ->toArray();
        }

        $this->syncUserAuthorsPivotData();
    }

    public function updatedUserAuthorsPivotData($value, $property)
    {
        $id = str($property)->before('.as')->toInteger();

        $this->userAuthorsArr = array_map(function ($user) use ($id, $value) {
            if ($user['id'] === $id) {
                $user['pivot']['as'] = filled($value) ? $value : null;
            }

            return $user;
        }, $this->userAuthorsArr);
    }

    public function userAuthors(): Collection
    {
        return collect($this->userAuthorsArr)
            ->map(fn ($user): object => $this->userObjectStructure($user));
    }

    private function userArrayStructure(User $user, ?int $pivotUserId = null): array
    {
        $pivotArray = empty($user->pivot)
            ? ['user' => User::find($pivotUserId), 'user_id' => $pivotUserId, 'as' => null]
            : ['user' => $user->pivot->user, 'user_id' => $user->pivot->user_id, 'as' => $user->pivot->as];

        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar_url' => $user->avatar_url,
            'pivot' => $pivotArray,
        ];
    }

    private function userObjectStructure(array $user): object
    {
        return (object) [
            'id' => data_get($user, 'id'),
            'name' => data_get($user, 'name'),
            'avatar_url' => data_get($user, 'avatar_url'),
            'pivot' => (object) [
                'user' => (object) data_get($user, 'pivot.user'),
                'user_id' => data_get($user, 'pivot.user_id'),
                'as' => data_get($user, 'pivot.as'),
            ],
        ];
    }

    private function syncUserAuthorsPivotData(): void
    {
        $this->userAuthorsPivotData = collect($this->userAuthorsArr)
            ->mapWithKeys(fn ($user): array => [
                $user['id'] => [
                    'user_id' => data_get($user, 'id'),
                    'as' => data_get($user, 'pivot.as'),
                ],
            ])
            ->toArray();
    }
}
