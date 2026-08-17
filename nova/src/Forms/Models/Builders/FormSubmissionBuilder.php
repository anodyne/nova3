<?php

declare(strict_types=1);

namespace Nova\Forms\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Nova\Characters\Models\Character;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Users\Models\User;

/**
 * @template TModel of FormSubmission
 *
 * @extends Builder<TModel>
 */
class FormSubmissionBuilder extends Builder
{
    public function forForm(Form|int $form): self
    {
        return $this->where('form_id', $form?->id ?? $form);
    }

    public function onlySubmissionsForCurrentUser(): self
    {
        return $this
            ->where(function (Builder $query): Builder {
                return $query
                    ->where(function (Builder $query): Builder {
                        return $query->where('owner_type', 'user')
                            ->where('owner_id', Auth::id());
                    })
                    ->orWhere(function (Builder $query): Builder {
                        return $query->where('owner_type', 'character')
                            ->whereIn('owner_id', function ($subQuery) {
                                $subQuery->select(Character::column('id'))
                                    ->from('characters')
                                    ->join('character_user', Character::column('id'), '=', 'character_user.character_id')
                                    ->where('character_user.user_id', Auth::id());
                            });
                    });
            });
    }

    public function ownerIsUser(User $user): self
    {
        return $this->where(function (Builder $query) use ($user): Builder {
            return $this
                ->where('owner_type', 'user')
                ->where('owner_id', $user->id);
        });
    }
}
