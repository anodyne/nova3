<?php

declare(strict_types=1);

namespace Nova\Users\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Nova\Characters\Models\Character;
use Nova\Foundation\Models\Builders\Concerns\ActiveBetween;
use Nova\Users\Data\UserModerations;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\States\Status\Hidden;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\States\Status\Pending;
use Nova\Users\Models\User;

/**
 * @template TModel of User
 *
 * @extends Builder<TModel>
 */
class UserBuilder extends Builder
{
    use ActiveBetween;

    public function active(): self
    {
        return $this->whereState('status', Active::class);
    }

    public function activeOrInactive(): self
    {
        return $this->whereAny(
            columns: ['status'],
            value: [
                Active::class,
                Inactive::class,
            ]
        );
    }

    public function countDistinct(): self
    {
        return $this->selectRaw('count(distinct('.User::column('id').'))');
    }

    public function hidden(): self
    {
        return $this->whereState('status', Hidden::class);
    }

    public function inactive(): self
    {
        return $this->whereState('status', Inactive::class);
    }

    public function moderatedOn(string $key): self
    {
        $versionInfo = DB::versionInfo();

        return match (true) {
            $versionInfo->isMysql => $this->whereRaw("JSON_EXTRACT(moderations, '$.$key') = true"),
            $versionInfo->isPostgres => $this->whereRaw("moderations->>'$key' = 'true'"),
            default => $this->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(moderations, '$.$key')) != 'true'")
        };
    }

    public function notHidden(): self
    {
        return $this->whereNotState('status', Hidden::class);
    }

    public function notPending(): self
    {
        return $this->whereNotState('status', Pending::class);
    }

    public function pending(): self
    {
        return $this->whereState('status', Pending::class);
    }

    public function searchFor(string $search): self
    {
        return $this
            ->whereAny(
                columns: [
                    User::column('name'),
                    User::column('email'),
                ],
                operator: 'like',
                value: "%{$search}%"
            )
            ->orWhereRelation('characters', Character::column('name'), 'like', "%{$search}%");
    }

    public function searchForBasic($search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }

    public function searchForWithoutCharacters(string $search): self
    {
        return $this->whereAny(['name', 'email'], 'like', "%{$search}%");
    }

    public function selectTotalCount(): self
    {
        return $this->selectRaw('COUNT(*) as total_count');
    }

    public function whereModerationDoesntHaveTrue(): self
    {
        $versionInfo = DB::versionInfo();

        $keys = UserModerations::resources();

        return match (true) {
            $versionInfo->isMysql => $this->where(function (Builder $query) use ($keys): void {
                foreach ($keys as $key) {
                    $query->whereRaw("JSON_EXTRACT(moderations, '$.$key') != true");
                }
            }),

            $versionInfo->isPostgres => $this->whereRaw('
                NOT EXISTS (
                    SELECT 1
                    FROM jsonb_each(moderations)
                    WHERE value::boolean = true
                )
            '),

            default => $this->where(function (Builder $query) use ($keys): void {
                foreach ($keys as $key) {
                    $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(moderations, '$.$key')) != 'true'");
                }
            }),
        };
    }

    public function whereModerationHasTrue(): self
    {
        $versionInfo = DB::versionInfo();

        $keys = UserModerations::resources();

        return match (true) {
            $versionInfo->isMysql => $this->where(function (Builder $query) use ($keys): void {
                foreach ($keys as $key) {
                    $query->orWhereRaw("JSON_EXTRACT(moderations, '$.$key') = true");
                }
            }),

            $versionInfo->isPostgres => $this->whereRaw('
                NOT EXISTS (
                    SELECT 1
                    FROM jsonb_each(moderations)
                    WHERE value::boolean = true
                )
            '),

            default => $this->where(function (Builder $query) use ($keys): void {
                foreach ($keys as $key) {
                    $query->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(moderations, '$.$key')) = 'true'");
                }
            }),
        };
    }
}
