<?php

declare(strict_types=1);
use BladeUI\Icons\BladeIconsServiceProvider;
use Lab404\Impersonate\ImpersonateServiceProvider;
use Livewire\LivewireServiceProvider;
use LivewireUI\Spotlight\SpotlightServiceProvider;
use Nova\Addons\Providers\AddonServiceProvider;
use Nova\Announcements\Providers\AnnouncementServiceProvider;
use Nova\Applications\Providers\ApplicationServiceProvider;
use Nova\Characters\Providers\CharacterServiceProvider;
use Nova\Dashboards\Providers\DashboardsServiceProvider;
use Nova\Departments\Providers\DepartmentServiceProvider;
use Nova\Discussions\Providers\DiscussionServiceProvider;
use Nova\Forms\Providers\FormServiceProvider;
use Nova\Foundation\Providers\AppServiceProvider;
use Nova\Foundation\Providers\FortifyServiceProvider;
use Nova\Media\Providers\MediaServiceProvider;
use Nova\Menus\Providers\MenusServiceProvider;
use Nova\Notes\Providers\NotesServiceProvider;
use Nova\Onboarding\Providers\OnboardingServiceProvider;
use Nova\Pages\Providers\PageServiceProvider;
use Nova\PublicSite\Providers\PublicSiteServiceProvider;
use Nova\Ranks\Providers\RankServiceProvider;
use Nova\Reporting\Providers\ReportingServiceProvider;
use Nova\Roles\Providers\RoleServiceProvider;
use Nova\Search\Providers\SearchServiceProvider;
use Nova\Settings\Providers\SettingsServiceProvider;
use Nova\Setup\Providers\SetupServiceProvider;
use Nova\Stories\Providers\PostServiceProvider;
use Nova\Stories\Providers\PostTypeServiceProvider;
use Nova\Stories\Providers\StoryServiceProvider;
use Nova\Themes\Providers\ThemeServiceProvider;
use Nova\Users\Providers\UserServiceProvider;

return [
    BladeIconsServiceProvider::class,
    ImpersonateServiceProvider::class,
    SpotlightServiceProvider::class,
    LivewireServiceProvider::class,
    AddonServiceProvider::class,
    AnnouncementServiceProvider::class,
    ApplicationServiceProvider::class,
    CharacterServiceProvider::class,
    DashboardsServiceProvider::class,
    DepartmentServiceProvider::class,
    DiscussionServiceProvider::class,
    FormServiceProvider::class,
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    MediaServiceProvider::class,
    MenusServiceProvider::class,
    NotesServiceProvider::class,
    OnboardingServiceProvider::class,
    PageServiceProvider::class,
    PublicSiteServiceProvider::class,
    RankServiceProvider::class,
    ReportingServiceProvider::class,
    RoleServiceProvider::class,
    SearchServiceProvider::class,
    SettingsServiceProvider::class,
    SetupServiceProvider::class,
    PostServiceProvider::class,
    PostTypeServiceProvider::class,
    StoryServiceProvider::class,
    ThemeServiceProvider::class,
    UserServiceProvider::class,
];
