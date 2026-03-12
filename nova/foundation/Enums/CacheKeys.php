<?php

declare(strict_types=1);

namespace Nova\Foundation\Enums;

enum CacheKeys: string
{
    case Addons = 'nova-addons';
    case AddonsLatestVersions = 'nova-addons-latest-versions';
    case AdvancedPages = 'nova-advanced-pages';
    case BasicMenu = 'nova-basic-menu';
    case BasicPages = 'nova-basic-pages';
    case ExternalChangelog = 'nova-external-changelog';
    case ExternalContent = 'nova-external-content';
    case FormDesignerForm = 'nova-form-designer-form';
    case LatestVersion = 'nova-latest-version';
    case MigrationAccountSetupComplete = 'nova-migration-account-setup-complete';
    case MigrationComplete = 'nova-migration-complete';
    case NextVersion = 'nova-next-version';
    case PageDesignerPage = 'nova-page-designer-page';
    case SearchableIcons = 'tabler-icons-searchable';
    case ThemesLatestVersions = 'nova-themes-latest-versions';
    case UpdateAvailable = 'nova-update-available';
    case UpdateUpcoming = 'nova-update-upcoming';
}
