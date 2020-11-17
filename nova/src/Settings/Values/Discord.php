<?php

namespace Nova\Settings\Values;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class Discord extends CastableDataTransferObject implements Arrayable
{
    public bool $storyPostsEnabled;

    public ?string $storyPostsWebhook;

    public ?string $storyPostsColor;

    public bool $applicationsEnabled;

    public ?string $applicationsWebhook;

    public ?string $applicationsColor;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'applicationsEnabled' => (bool) $request->input('applications.enabled', false),
            'applicationsWebhook' => $request->input('applications.webhook'),
            'applicationsColor' => $request->input('applications.color'),

            'storyPostsEnabled' => (bool) $request->input('storyPosts.enabled', false),
            'storyPostsWebhook' => $request->input('storyPosts.webhook'),
            'storyPostsColor' => $request->input('storyPosts.color'),
        ]);
    }
}
