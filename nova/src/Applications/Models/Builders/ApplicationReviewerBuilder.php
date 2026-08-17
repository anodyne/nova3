<?php

declare(strict_types=1);

namespace Nova\Applications\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Applications\Enums\ReviewerType;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Users\Models\Builders\UserBuilder;

/**
 * @template TModel of ApplicationReviewer
 *
 * @extends Builder<TModel>
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
            ->whereHas('user', fn (UserBuilder $query): UserBuilder => $query->active()->whereHasPermission('application.approve'));
    }
}
