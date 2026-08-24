<?php

declare(strict_types=1);

namespace Nova\Announcements\Controllers;

use Illuminate\Http\RedirectResponse;
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
use Nova\Foundation\Responses\Responsable;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Announcement::class);
    }

    public function index(): Responsable
    {
        return ListAnnouncementsResponse::send();
    }

    public function show(Announcement $announcement): Responsable
    {
        defer(fn (): mixed => MarkAnnouncementRead::run($announcement, Auth::user()));

        return ShowAnnouncementResponse::sendWith([
            'announcement' => $announcement->loadMissing('user'),
        ]);
    }

    public function create(): Responsable
    {
        return CreateAnnouncementResponse::sendWith([
            'categories' => Announcement::uniqueCategories()->pluck('category')->filter(),
        ]);
    }

    public function store(StoreAnnouncementRequest $request): RedirectResponse
    {
        $announcement = CreateAnnouncement::run($request->getAnnouncementData());

        return to_route('admin.announcements.index')
            ->notify("{$announcement->title} announcement was created");
    }

    public function edit(Announcement $announcement): Responsable
    {
        return EditAnnouncementResponse::sendWith([
            'announcement' => $announcement,
            'categories' => Announcement::uniqueCategories()->pluck('category'),
        ]);
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        $announcement = UpdateAnnouncement::run(
            $announcement,
            $request->getAnnouncementData()
        );

        return back()->notify("{$announcement->title} has been updated");
    }
}
