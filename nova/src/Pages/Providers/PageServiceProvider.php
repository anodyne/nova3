<?php

declare(strict_types=1);

namespace Nova\Pages\Providers;

use Nova\DomainServiceProvider;
use Nova\Pages\Livewire\AlternatingStories;
use Nova\Pages\Livewire\CharactersManifest;
use Nova\Pages\Livewire\DynamicForm;
use Nova\Pages\Livewire\PageDesigner;
use Nova\Pages\Livewire\PagesList;
use Nova\Pages\Livewire\StatWidget;
use Nova\Pages\Models\Page;
use Nova\Pages\Spotlight;

class PageServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'pages-designer' => PageDesigner::class,
            'pages-list' => PagesList::class,
            'pages-alternating-stories' => AlternatingStories::class,
            'pages-characters-manifest' => CharactersManifest::class,
            'pages-dynamic-form' => DynamicForm::class,
            'pages-stat-widget' => StatWidget::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'page' => Page::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            Spotlight\DesignPage::class,
            Spotlight\ViewPage::class,
            Spotlight\ViewPages::class,
        ];
    }
}
