<?php

namespace Nova\Authorize\Jobs;

use Nova\Authorize\Role;
use Illuminate\Bus\Queueable;
use Nova\Foundation\Jobs\BaseJob;
use Nova\Foundation\Traits\BustsCache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteRoleJob extends BaseJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, BustsCache;

	protected $modelClass = Role::class;
	protected $description = 'deleting a role';

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Clean up any permissions that have this role
		$this->model->removePermissions();

		// Delete the role
		$this->model->delete();

		// Bust the cache
		$this->refreshCacheForever('nova.roles', function () {
			return Role::with('permissions')->get();
		});
	}
}
