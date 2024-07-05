<?php

declare(strict_types=1);

namespace Nova\Characters\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Characters\Data\AssignCharacterOwnersData;
use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Characters\Data\CharacterData;
use Nova\Characters\Models\Character;
use Nova\Forms\Models\Form;

class StoreCharacterRequest extends FormRequest
{
    public function authorize(): bool
    {
        $linkToUser = $this->boolean('link_to_user');
        $assignPrimary = $this->boolean('assign_as_primary');
        $user = $this->user();

        return match (true) {
            $user->can('create', Character::class) => true,
            ! $linkToUser && ! $assignPrimary && $user->cannot('createSupport', Character::class) => false,
            $assignPrimary && $user->cannot('createPrimary', Character::class) => false,
            $linkToUser && ! $assignPrimary && $user->cannot('createSecondary', Character::class) => false,
            $linkToUser && ($user->cannot('createPrimary', Character::class) && $user->cannot('createSecondary', Character::class)) => false,
            ! $linkToUser && $user->cannot('createSupport', Character::class) => false,
            default => true,
        };
    }

    public function rules(): array
    {
        return array_merge(
            [
                'name' => ['required'],
                'rank_id' => ['nullable'],
            ],
            Form::key('characterBio')->first()->validation_rules,
        );
    }

    public function messages(): array
    {
        return array_merge(
            [
                'name.required' => ':attribute is required',
            ],
            Form::key('characterBio')->first()->validation_messages,
        );
    }

    public function getCharacterData(): CharacterData
    {
        return CharacterData::from($this);
    }

    public function getCharacterOwnersData(): AssignCharacterOwnersData
    {
        return AssignCharacterOwnersData::from($this);
    }

    public function getAutoLinkedCharacterOwnersData(): AssignCharacterOwnersData
    {
        return AssignCharacterOwnersData::from([
            'users' => $this->boolean('link_to_user') ? [auth()->id()] : [],
            'primaryUsers' => $this->boolean('assign_as_primary') ? [auth()->id()] : [],
        ]);
    }

    public function getCharacterPositionsData(): AssignCharacterPositionsData
    {
        return AssignCharacterPositionsData::from($this);
    }
}
