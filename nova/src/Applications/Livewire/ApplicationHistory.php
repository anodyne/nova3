<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Schemas\Schema;
use Livewire\Attributes\Locked;
use Nova\Applications\Models\Application;
use Nova\Foundation\Helpers\DateHelper;
use Nova\Foundation\Livewire\InfolistComponent;
use Nova\Ranks\Models\RankItem;
use Nova\Users\Models\User;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;
use Spatie\Activitylog\Models\Activity;

class ApplicationHistory extends InfolistComponent
{
    #[Locked]
    public Application $application;

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->application)
            ->components([
                Timeline::make()
                    ->hiddenLabel()
                    ->attributeLabels([
                        'rank_id' => 'rank',
                    ])
                    ->attributeValues([
                        'decision_date' => fn ($value) => filled($value) ? DateHelper::formatDate($value) : null,
                        'rank_id' => fn ($value) => filled($value) ? RankItem::find($value)?->name?->name : null,
                    ])
                    ->eventDescriptions([
                        'message-added' => fn (Activity $activity) => __('activity.applications.message-added', [
                            'name' => $activity->causer->name,
                        ]),
                        'reviewers-added' => fn (Activity $activity) => trans_choice(
                            'activity.applications.reviewers-added',
                            count($activity->getExtraProperty('addedReviewers')),
                            [
                                'name' => $activity->causer->name,
                                'reviewers' => User::whereIn('id', $activity->getExtraProperty('addedReviewers'))
                                    ->get()
                                    ->pluck('name')
                                    ->join(', '),
                            ]
                        ),
                        'reviewers-removed' => fn (Activity $activity) => trans_choice(
                            'activity.applications.reviewers-removed',
                            count($activity->getExtraProperty('removedReviewers')),
                            [
                                'name' => $activity->causer->name,
                                'reviewers' => User::whereIn('id', $activity->getExtraProperty('removedReviewers'))
                                    ->get()
                                    ->pluck('name')
                                    ->join(', '),
                            ]
                        ),
                        'vote-accept' => fn (Activity $activity) => __('activity.applications.vote-accept', [
                            'name' => $activity->causer->name,
                        ]),
                        'vote-deny' => fn (Activity $activity) => __('activity.applications.vote-deny', [
                            'name' => $activity->causer->name,
                        ]),
                    ])
                    ->itemIcons([
                        'accepted' => Tabler::ProgressCheck->value,
                        'denied' => Tabler::ProgressX->value,
                    ])
                    ->itemIconColors([
                        'accepted' => 'success',
                        'denied' => 'danger',
                        'vote-accept' => 'success',
                        'vote-deny' => 'danger',
                    ]),
            ]);
    }
}
