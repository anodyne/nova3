<?php

declare(strict_types=1);

use Nova\Foundation\Actions\Action;
use Nova\Search\Actions\BuildSearchIndex;
use Nova\Search\Actions\FlushSearchIndex;
use Nova\Stories\Actions\PruneAbandonedPosts;
use Nova\Stories\Actions\ReleaseExpiredPostLocks;
use Nova\Themes\Actions\SetupThemeDirectory;

arch('uses the base action for synchronous domain actions')
    ->expect([
        'Nova\\Addons\\Actions',
        'Nova\\Announcements\\Actions',
        'Nova\\Applications\\Actions',
        'Nova\\Characters\\Actions',
        'Nova\\Departments\\Actions',
        'Nova\\Discussions\\Actions',
        'Nova\\Forms\\Actions',
        'Nova\\Foundation\\Actions',
        'Nova\\Media\\Actions',
        'Nova\\Menus\\Actions',
        'Nova\\Notes\\Actions',
        'Nova\\Onboarding\\Actions',
        'Nova\\Pages\\Actions',
        'Nova\\PublicSite\\Actions',
        'Nova\\Ranks\\Actions',
        'Nova\\Roles\\Actions',
        'Nova\\Search\\Actions',
        'Nova\\Settings\\Actions',
        'Nova\\Stories\\Actions',
        'Nova\\Themes\\Actions',
        'Nova\\Users\\Actions',
    ])
    ->toExtend(Action::class)
    ->ignoring([
        Action::class,
        'Nova\\Foundation\\Actions\\Fortify',
        BuildSearchIndex::class,
        FlushSearchIndex::class,
        PruneAbandonedPosts::class,
        ReleaseExpiredPostLocks::class,
        SetupThemeDirectory::class,
    ]);
