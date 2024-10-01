<?php

declare(strict_types=1);

namespace Nova\Announcements\Controllers;

use Illuminate\Support\Facades\Auth;
use Nova\Announcements\Actions\CreateAnnouncement;
use Nova\Announcements\Actions\MarkAnnouncementRead;
use Nova\Announcements\Actions\UpdateAnnouncement;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Requests\StoreAnnouncementRequest;
use Nova\Announcements\Requests\UpdateAnnouncementRequest;
use Nova\Announcements\Responses\CreateAnnouncementResponse;
use Nova\Announcements\Responses\EditAnnouncementResponse;
use Nova\Announcements\Responses\ListAnnouncementsResponse;
use Nova\Announcements\Responses\ShowAnnouncementResponse;
use Nova\Foundation\Controllers\Controller;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Announcement::class);
    }

    public function index()
    {
        return ListAnnouncementsResponse::send();
    }

    public function show(Announcement $announcement)
    {
        MarkAnnouncementRead::run($announcement, Auth::user());

        return ShowAnnouncementResponse::sendWith([
            'announcement' => $announcement->loadMissing('user'),
        ]);
    }

    public function create()
    {
        return CreateAnnouncementResponse::sendWith([
            'categories' => Announcement::select('category')->distinct()->pluck('category'),
        ]);
    }

    public function store(StoreAnnouncementRequest $request)
    {
        $announcement = CreateAnnouncement::run($request->getAnnouncementData());

        return to_route('admin.announcements.index')
            ->notify("{$announcement->title} announcement was created");
    }

    public function edit(Announcement $announcement)
    {
        return EditAnnouncementResponse::sendWith([
            'announcement' => $announcement,
            'categories' => Announcement::select('category')->distinct()->pluck('category'),
        ]);
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $announcement = UpdateAnnouncement::run($announcement, $request->getAnnouncementData());

        return back()
            ->notify("{$announcement->title} has been updated");
    }
}
