<?php

declare(strict_types=1);

namespace Nova\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Users\Data\BanData;

class StoreBanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bannable_id' => ['nullable'],
            'ip' => ['nullable'],
            'expired_at' => ['nullable'],
            'comment' => ['nullable'],
        ];
    }

    public function getBanData(): BanData
    {
        return BanData::from($this);
    }
}
