<?php

declare(strict_types=1);

namespace Nova\Applications\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Applications\Data\ApplicationData;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Applications\Notifications\ApplicationReadyForReview;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Actions\SyncFormSubmissionResponses;
use Nova\Forms\Models\Form;
use Nova\Users\Models\User;
use Spatie\Activitylog\Facades\LogBatch;

class CreateApplicationManager
{
    use AsAction;

    /**
     * @param  array<string, mixed>  $applicationInfoData
     */
    public function handle(ApplicationData $data, array $applicationInfoData = []): Application
    {
        return DB::transaction(function () use ($data, $applicationInfoData) {
            LogBatch::startBatch();

            $application = CreateApplication::run($data);

            $this->createFormSubmissionForApplication($application, $applicationInfoData);

            $this->createDiscussion($application);

            $this->addReviewersToApplication($application);

            $this->notifyReviewers($application);

            LogBatch::endBatch();

            return $application->refresh();
        });
    }

    protected function createDiscussion(Application $application): void
    {
        $application->discussion()->create();
    }

    protected function addReviewersToApplication(Application $application): void
    {
        $application->reviews()->sync(User::whereHasPermission('application.approve')->get());

        $application->reviews()->syncWithoutDetaching(ApplicationReviewer::global()->get()->pluck('user_id'));
    }

    protected function notifyReviewers(Application $application): void
    {
        $application->refresh();

        $application->reviews->each->notify(new ApplicationReadyForReview($application));
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function createFormSubmissionForApplication(Application $application, array $data = []): void
    {
        $submission = CreateFormSubmission::run(
            Form::key('applicationInfo')->first(),
            $application
        );

        SyncFormSubmissionResponses::run($submission, $data);
    }
}
