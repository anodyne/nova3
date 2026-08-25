<?php

declare(strict_types=1);

namespace Nova\Applications\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Applications\Enums\ReviewerType;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Users\Models\Builders\UserBuilder;

/**
 * @extends Builder<ApplicationReviewer>
 */
class ApplicationReviewerBuilder extends Builder
{
    public function conditional(): self
    {
        return $this->where('type', ReviewerType::Conditional);
    }

    public function global(): self
    {
        return $this->where('type', ReviewerType::Global);
    }

    public function globalReviewersWithApprovalPermission(): self
    {
        return $this->withoutGlobalScopes()
            ->global()
            ->whereHas('user', function (Builder $query): void {
                /** @var UserBuilder $userQuery */
                $userQuery = $query;

                $userQuery->active()->whereHasPermission('application.approve');
            });
    }
}
