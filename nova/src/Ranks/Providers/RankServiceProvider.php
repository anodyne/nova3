<?php

namespace Nova\Ranks\Providers;

use Nova\DomainServiceProvider;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Policies\RankGroupPolicy;
use Nova\Ranks\Http\Responses\ShowRankGroupResponse;
use Nova\Ranks\Http\Responses\CreateRankGroupResponse;
use Nova\Ranks\Http\Responses\UpdateRankGroupResponse;
use Nova\Ranks\Http\Responses\ShowAllRankGroupsResponse;

class RankServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        RankGroup::class => RankGroupPolicy::class,
    ];

    protected $responsables = [
        CreateRankGroupResponse::class,
        ShowRankGroupResponse::class,
        ShowAllRankGroupsResponse::class,
        UpdateRankGroupResponse::class,
    ];
}
