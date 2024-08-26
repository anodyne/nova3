<?php

declare(strict_types=1);

return [
    BladeUI\Icons\BladeIconsServiceProvider::class,
    Lab404\Impersonate\ImpersonateServiceProvider::class,
    Livewire\LivewireServiceProvider::class,
    LivewireUI\Spotlight\SpotlightServiceProvider::class,

    Nova\Foundation\Providers\AppServiceProvider::class,
    Nova\Foundation\Providers\FortifyServiceProvider::class,

    Nova\Setup\Providers\SetupServiceProvider::class,
    Nova\Applications\Providers\ApplicationServiceProvider::class,
    Nova\Characters\Providers\CharacterServiceProvider::class,
    Nova\Conversations\Providers\ConversationServiceProvider::class,
    Nova\Dashboards\Providers\DashboardsServiceProvider::class,
    Nova\Departments\Providers\DepartmentServiceProvider::class,
    Nova\Forms\Providers\FormServiceProvider::class,
    Nova\Media\Providers\MediaServiceProvider::class,
    Nova\Menus\Providers\MenusServiceProvider::class,
    // Nova\Navigation\Providers\NavigationServiceProvider::class,
    Nova\Notes\Providers\NotesServiceProvider::class,
    Nova\Pages\Providers\PageServiceProvider::class,
    Nova\PublicSite\Providers\PublicSiteServiceProvider::class,
    Nova\Ranks\Providers\RankServiceProvider::class,
    Nova\Roles\Providers\RoleServiceProvider::class,
    Nova\Settings\Providers\SettingsServiceProvider::class,
    Nova\Stories\Providers\PostServiceProvider::class,
    Nova\Stories\Providers\PostTypeServiceProvider::class,
    Nova\Stories\Providers\StoryServiceProvider::class,
    Nova\Themes\Providers\ThemeServiceProvider::class,
    Nova\Users\Providers\UserServiceProvider::class,
];
