<?php

declare(strict_types=1);

namespace Nova\Applications\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Applications\Enums\ReviewerType;

class ApplicationReviewerBuilder extends Builder
{
    public function conditional(): Builder
    {
        return $this->where('type', ReviewerType::Conditional);
    }

    public function global(): Builder
    {
        return $this->where('type', ReviewerType::Global);
    }

    public function globalReviewersWithApprovalPermission(): Builder
    {
        return $this->withoutGlobalScopes()
            ->global()
            ->whereHas('user', fn (Builder $query): Builder => $query->active()->whereHasPermission('application.approve'));
    }
}
