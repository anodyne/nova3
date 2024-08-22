<?php

declare(strict_types=1);

namespace Nova\PublicSite\Controllers;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Nova\Departments\Models\Department;
use Nova\Forms\Models\Form;
use Nova\Foundation\Controllers\Controller;
use Nova\PublicSite\Responses\ShowJoinFormResponse;

class ShowJoinFormController extends Controller
{
    public function __invoke(?int $position = null)
    {
        return ShowJoinFormResponse::sendWith([
            'applicationInfoForm' => Form::key('applicationInfo')->first(),
            'characterBioForm' => Form::key('characterBio')->first(),
            'userBioForm' => Form::key('userBio')->first(),
            'departments' => Department::query()
                ->whereHas('positions', fn (Builder $query): Builder => $query->active()->available())
                ->with(['positions' => fn (Builder $query): Builder => $query->active()->available()])
                ->active()
                ->ordered()
                ->get(),
            'selectedPosition' => $position,
        ]);
    }
}
