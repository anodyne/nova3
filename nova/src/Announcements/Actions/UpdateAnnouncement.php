<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Data\AnnouncementData;
use Nova\Announcements\Models\Announcement;
use Nova\Foundation\Enums\PublishStatus;

class UpdateAnnouncement
{
    use AsAction;

    public function handle(Announcement $announcement, AnnouncementData $data): Announcement
    {
        return DB::transaction(function () use ($announcement, $data): Announcement {
            $announcement->update($this->setUpdateData(announcement: $announcement, data: $data));

            $announcement = $announcement->fresh();

            NotifyUsers::runIf($announcement->status === PublishStatus::Published, $announcement);

            return $announcement;
        });
    }

    private function setUpdateData(Announcement $announcement, AnnouncementData $data): array
    {
        $publishing = $announcement->status !== PublishStatus::Published && $data->status === PublishStatus::Published;

        if (! $publishing) {
            return [
                ...$data->toArray(),
                ...['published_at' => $announcement->published_at],
            ];
        }

        /** @var User $user */
        $user = Auth::user();

        if ($user->isModerated()) {
            return [
                ...$data->append(['status' => PublishStatus::Pending])->toArray(),
                ...['published_at' => null],
            ];
        }

        return [
            ...$data->toArray(),
            ...['published_at' => Date::now()],
        ];
    }
}
