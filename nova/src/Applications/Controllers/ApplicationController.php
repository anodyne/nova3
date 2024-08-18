<?php

declare(strict_types=1);

namespace Nova\Applications\Controllers;

use Nova\Applications\Models\Application;
use Nova\Applications\Responses\ListApplicationsResponse;
use Nova\Applications\Responses\ShowApplicationResponse;
use Nova\Forms\Models\Form;
use Nova\Foundation\Controllers\Controller;

class ApplicationController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Application::class);
    }

    public function index()
    {
        return ListApplicationsResponse::send();
    }

    public function show(Application $application)
    {
        $application->load(
            'user.userFormSubmission',
            'character.characterFormSubmission',
            'applicationFormSubmission',
            'discussion.messages'
        );

        $application->loadCount('reviews', 'acceptedReviews', 'deniedReviews', 'noResultReviews');

        return ShowApplicationResponse::sendWith([
            'application' => $application,
            'applicationInfoForm' => Form::key('applicationInfo')->first(),
            'characterBioForm' => Form::key('characterBio')->first(),
            'userBioForm' => Form::key('userBio')->first(),
        ]);
    }
}
