<?php

namespace Nova\Authorize\Jobs;

use Illuminate\Bus\Queueable;
use Nova\Authorize\Permission;
use Nova\Foundation\Jobs\BaseJob;
use Nova\Foundation\Traits\BustsCache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeletePermissionJob extends BaseJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, BustsCache;

	protected $modelClass = Permission::class;
	protected $description = 'deleting a permission';

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Clean up any roles that have this permission
		$this->model->roles()->sync([]);

		// Delete the permission
		$this->model->delete();

		// Bust the cache
		$this->refreshCacheForever('nova.permissions', function () {
			return Permission::with('roles')->get();
		});
	}
}
