<?php

declare(strict_types=1);

namespace Nova\PublicSite\Controllers;

use Nova\Departments\Models\Builders\PositionBuilder;
use Nova\Departments\Models\Department;
use Nova\Forms\Models\Form;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\PublicSite\Responses\ShowJoinFormResponse;

class ShowJoinFormController extends Controller
{
    public function __invoke(?int $position = null): Responsable
    {
        return ShowJoinFormResponse::sendWith([
            'applicationInfoForm' => Form::key('applicationInfo')->first(),
            'characterBioForm' => Form::key('characterBio')->first(),
            'userBioForm' => Form::key('userBio')->first(),
            'departments' => Department::query()
                ->withWhereHas('positions', function ($query): void {
                    /** @var PositionBuilder $positionQuery */
                    $positionQuery = $query;

                    $positionQuery->active()->available();
                })
                ->active()
                ->ordered()
                ->get(),
            'selectedPosition' => $position,
        ]);
    }
}
