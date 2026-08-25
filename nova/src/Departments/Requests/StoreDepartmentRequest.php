<?php

declare(strict_types=1);

namespace Nova\Departments\Requests;

use Illuminate\Contracts\Validation\Rule as ValidationRuleContract;
use Illuminate\Foundation\Http\FormRequest;
use Nova\Departments\Data\DepartmentData;
use Nova\Media\Enums\ImageAction;

class StoreDepartmentRequest extends FormRequest
{
    /**
     * @return array<string, array<int, ValidationRuleContract|string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['nullable'],
            'status' => ['sometimes'],
            'tags' => ['nullable'],
        ];
    }

    public function getDepartmentData(): DepartmentData
    {
        return DepartmentData::from($this);
    }

    public function getImageAction(): ImageAction
    {
        return $this->enum('image_action', ImageAction::class) ?? ImageAction::Unchanged;
    }

    public function getImageTempPath(): ?string
    {
        return $this->string('image_temp_path')->toString() ?: null;
    }
}
