<?php

namespace Nova\Ranks\Providers;

use Nova\Ranks\Http\Responses;
use Nova\DomainServiceProvider;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Policies\RankItemPolicy;
use Nova\Ranks\Policies\RankGroupPolicy;
use Nova\Ranks\Policies\RankNamePolicy;

class RankServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        RankGroup::class => RankGroupPolicy::class,
        RankItem::class => RankItemPolicy::class,
        RankName::class => RankNamePolicy::class,
    ];

    protected $responsables = [
        Responses\ShowRankOptionsResponse::class,

        Responses\Groups\CreateRankGroupResponse::class,
        Responses\Groups\DuplicateRankGroupResponse::class,
        Responses\Groups\ShowAllRankGroupsResponse::class,
        Responses\Groups\ShowRankGroupResponse::class,
        Responses\Groups\UpdateRankGroupResponse::class,

        Responses\Names\CreateRankNameResponse::class,
        Responses\Names\ShowAllRankNamesResponse::class,
        Responses\Names\ShowRankNameResponse::class,
        Responses\Names\UpdateRankNameResponse::class,

        Responses\Items\CreateRankItemResponse::class,
        Responses\Items\ShowAllRankItemsResponse::class,
        Responses\Items\ShowRankItemResponse::class,
    ];
}
