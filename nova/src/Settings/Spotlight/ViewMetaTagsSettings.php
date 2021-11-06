<?php

declare(strict_types=1);

namespace Nova\Settings\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewMetaTagsSettings extends SpotlightCommand
{
    protected string $name = 'Meta Tags';

    protected string $description = "View Nova's meta tags settings";

    protected array $synonyms = [
        'seo', 'search engine optimization',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('settings.index', 'meta-tags');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', settings());
    }
}
