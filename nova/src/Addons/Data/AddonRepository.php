<?php

declare(strict_types=1);

namespace Nova\Addons\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Nova\Addons\Enums\AddonRepositoryType;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class AddonRepository extends Data implements Arrayable
{
    public function __construct(
        #[Enum(AddonRepositoryType::class)]
        public ?AddonRepositoryType $type,

        public ?string $id
    ) {}

    public function endpoint(): ?Response
    {
        if ($this->type === AddonRepositoryType::Anodyne) {
            return Http::get('https://anodyne-productions.com.test/api/addon/'.$this->id.'/latest-version');
        }

        if ($this->type === AddonRepositoryType::Github) {
            return Http::withHeader('X-GitHub-Api-Version', '2022-11-28')
                ->get('https://api.github.com/repos/'.$this->id.'/releases/latest');
        }

        return null;
    }

    public function endpointData(): mixed
    {
        if ($this->type === AddonRepositoryType::Anodyne) {
            return $this->endpoint()->json();
        }

        if ($this->type === AddonRepositoryType::Github) {
            $json = $this->endpoint()->json();

            $repo = Http::withHeader('X-GitHub-Api-Version', '2022-11-28')
                ->get('https://api.github.com/repos/'.$this->id);

            return [
                'name' => $repo->json('name'),
                'version' => data_get($json, 'tag_name'),
                'id' => $this->id,
                'url' => data_get($json, 'html_url'),
            ];
        }

        return null;
    }
}
