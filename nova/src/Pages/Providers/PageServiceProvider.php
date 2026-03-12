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
use Nova\Pages\Spotlight\DesignPage;
use Nova\Pages\Spotlight\ViewPage;
use Nova\Pages\Spotlight\ViewPages;

class PageServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'pages-alternating-stories' => AlternatingStories::class,
            'pages-characters-manifest' => CharactersManifest::class,
            'pages-designer' => PageDesigner::class,
            'pages-dynamic-form' => DynamicForm::class,
            'pages-list' => PagesList::class,
            'pages-stat-widget' => StatWidget::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'page' => Page::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'page_' => Page::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            DesignPage::class,
            ViewPage::class,
            ViewPages::class,
        ];
    }
}
