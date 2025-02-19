<?php

declare(strict_types=1);

namespace Nova\Pages\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Pages\Enums\PageVerb;

/**
 * @method static static from(string $name, string $key, string $uri, PageVerb $verb, BasicStatus $status, ?string $resource, string $layout, ?string $seo_title, ?string $seo_description, ?string $seo_keywords, ?string $heading, ?string $subheading, ?string $intro)
 */
readonly class PageData extends Bag
{
    public function __construct(
        public string $name,
        public string $key,
        public string $uri,
        public PageVerb $verb,
        public BasicStatus $status,
        public ?string $resource,
        public string $layout,
        public ?string $seo_title,
        public ?string $seo_description,
        public ?string $seo_keywords,
        public ?string $heading,
        public ?string $subheading,
        public ?string $intro,
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'key' => $request->input('key'),
            'uri' => $request->input('uri'),
            'verb' => PageVerb::tryFrom($request->input('verb')) ?? PageVerb::Get,
            'status' => BasicStatus::tryFrom($request->input('status')) ?? BasicStatus::Active,
            'resource' => $request->input('resource'),
            'layout' => $request->input('layout'),
            'seo_title' => $request->input('seo_title'),
            'seo_description' => $request->input('seo_description'),
            'seo_keywords' => $request->input('seo_keywords'),
            'heading' => $request->input('heading'),
            'subheading' => $request->input('subheading'),
            'intro' => $request->input('intro'),
        ];
    }
}
