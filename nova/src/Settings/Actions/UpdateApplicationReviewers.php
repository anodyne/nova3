<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Applications\Enums\ReviewerType;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Settings\Data\ApplicationReviewers;

class UpdateApplicationReviewers
{
    use AsAction;

    public function handle(ApplicationReviewers $data): void
    {
        DB::transaction(function () use ($data): void {
            $this->updateGlobalReviewers($data);
        });
    }

    protected function updateGlobalReviewers(ApplicationReviewers $data): void
    {
        // Remove all reviewers who are not in the payload
        ApplicationReviewer::whereNotIn('user_id', $data->globalReviewers)->delete();

        collect($data->globalReviewers)->each(
            fn (int $userId) => ApplicationReviewer::firstOrCreate(['user_id' => $userId], ['type' => ReviewerType::Global])
        );
    }
}
