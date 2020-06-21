<?php

namespace Nova\Ranks\Providers;

use Nova\DomainServiceProvider;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Policies\RankNamePolicy;
use Nova\Ranks\Policies\RankGroupPolicy;
use Nova\Ranks\Http\Responses\ShowRankNameResponse;
use Nova\Ranks\Http\Responses\ShowRankGroupResponse;
use Nova\Ranks\Http\Responses\CreateRankItemResponse;
use Nova\Ranks\Http\Responses\CreateRankNameResponse;
use Nova\Ranks\Http\Responses\UpdateRankNameResponse;
use Nova\Ranks\Http\Responses\CreateRankGroupResponse;
use Nova\Ranks\Http\Responses\DuplicateRankGroupResponse;
use Nova\Ranks\Http\Responses\ShowRankOptionsResponse;
use Nova\Ranks\Http\Responses\UpdateRankGroupResponse;
use Nova\Ranks\Http\Responses\ShowAllRankNamesResponse;
use Nova\Ranks\Http\Responses\ShowAllRankGroupsResponse;
use Nova\Ranks\Http\Responses\ShowAllRankItemsResponse;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Policies\RankItemPolicy;

class RankServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        RankGroup::class => RankGroupPolicy::class,
        RankItem::class => RankItemPolicy::class,
        RankName::class => RankNamePolicy::class,
    ];

    protected $responsables = [
        ShowRankOptionsResponse::class,

        CreateRankGroupResponse::class,
        DuplicateRankGroupResponse::class,
        ShowRankGroupResponse::class,
        ShowAllRankGroupsResponse::class,
        UpdateRankGroupResponse::class,

        CreateRankNameResponse::class,
        ShowRankNameResponse::class,
        ShowAllRankNamesResponse::class,
        UpdateRankNameResponse::class,

        CreateRankItemResponse::class,
        ShowAllRankItemsResponse::class,
    ];
}
