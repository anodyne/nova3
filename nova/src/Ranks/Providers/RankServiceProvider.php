<?php

declare(strict_types=1);

namespace Nova\Ranks\Providers;

use Nova\DomainServiceProvider;
use Nova\Ranks\Livewire\RankGroupsDropdown;
use Nova\Ranks\Livewire\RankItemsDropdown;
use Nova\Ranks\Livewire\RankNamesDropdown;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Policies\RankGroupPolicy;
use Nova\Ranks\Policies\RankItemPolicy;
use Nova\Ranks\Policies\RankNamePolicy;
use Nova\Ranks\Responses;

class RankServiceProvider extends DomainServiceProvider
{
    protected $livewireComponents = [
        'ranks:items-dropdown' => RankItemsDropdown::class,
        'ranks:groups-dropdown' => RankGroupsDropdown::class,
        'ranks:names-dropdown' => RankNamesDropdown::class,
    ];

    protected $policies = [
        RankGroup::class => RankGroupPolicy::class,
        RankItem::class => RankItemPolicy::class,
        RankName::class => RankNamePolicy::class,
    ];

    protected $responsables = [
        Responses\ShowRankOptionsResponse::class,

        Responses\Groups\CreateRankGroupResponse::class,
        Responses\Groups\DeleteRankGroupResponse::class,
        Responses\Groups\DuplicateRankGroupResponse::class,
        Responses\Groups\ShowAllRankGroupsResponse::class,
        Responses\Groups\ShowRankGroupResponse::class,
        Responses\Groups\UpdateRankGroupResponse::class,

        Responses\Names\CreateRankNameResponse::class,
        Responses\Names\DeleteRankNameResponse::class,
        Responses\Names\ShowAllRankNamesResponse::class,
        Responses\Names\ShowRankNameResponse::class,
        Responses\Names\UpdateRankNameResponse::class,

        Responses\Items\CreateRankItemResponse::class,
        Responses\Items\DeleteRankItemResponse::class,
        Responses\Items\ShowAllRankItemsResponse::class,
        Responses\Items\ShowRankItemResponse::class,
        Responses\Items\UpdateRankItemResponse::class,
    ];
}
