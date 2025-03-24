<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Data\BanData;
use Nova\Users\Models\Ban;
use Nova\Users\Models\States\Status\Banned;

class BanUserManager
{
    use AsAction;

    public function handle(BanData $data): Ban
    {
        return DB::transaction(function () use ($data) {
            if ($data->bannable_id) {
                $ban = $data->user()->ban([
                    'created_by_type' => 'user',
                    'created_by_id' => Auth::id(),
                    'comment' => $data->comment,
                    'expired_at' => $data->expired_at,
                ]);

                if ($data->user()->status->canTransitionTo(Banned::class)) {
                    $data->user()->status->transitionTo(Banned::class);
                }

                activity()
                    ->performedOn($data->user())
                    ->event('banned')
                    ->log('banned');

                return $ban;
            }

            return Ban::create(Arr::except($data->toArray(), ['bannable_type', 'bannable_id']));
        });
    }
}
