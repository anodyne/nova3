<?php

declare(strict_types=1);

namespace Nova\Notes\Requests;

use Illuminate\Contracts\Validation\Rule as ValidationRuleContract;
use Illuminate\Foundation\Http\FormRequest;
use Nova\Notes\Data\NoteData;

class StoreNoteRequest extends FormRequest
{
    /**
     * @return array<string, array<int, ValidationRuleContract|string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'content' => ['nullable'],
        ];
    }

    public function getNoteData(): NoteData
    {
        return NoteData::from($this);
    }
}
