<?php

declare(strict_types=1);

namespace Nova\Addons\Data;

use Bag\Bag;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Nova\Addons\Enums\AddonRepositoryType;

/**
 * @method static static from(?AddonRepositoryType $type, ?string $id)
 */
readonly class AddonRepository extends Bag
{
    public function __construct(
        public ?AddonRepositoryType $type,
        public ?string $id
    ) {}

    public function endpoint(): ?Response
    {
        if ($this->type === AddonRepositoryType::Anodyne) {
            $url = Str::replaceArray('{id}', [$this->id], config('services.anodyne.api.addon-version-check'));

            return Http::get($url);
        }

        if ($this->type === AddonRepositoryType::Github) {
            $url = Str::replaceArray('{id}', [$this->id], config('services.github.api.latest-release'));

            return Http::withHeader('X-GitHub-Api-Version', config('services.github.version'))->get($url);
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

            $repo = Http::withHeader('X-GitHub-Api-Version', config('services.github.version'))
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
