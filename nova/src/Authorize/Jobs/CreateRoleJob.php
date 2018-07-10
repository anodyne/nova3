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

class CreateRoleJob extends BaseJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, BustsCache;

	protected $modelClass = Role::class;
	protected $description = 'creating a role';

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Create the role
		$role = Role::create($this->data);

		// Attach the permissions to the role if we have them
		if (array_key_exists('permissions', $this->data)) {
			$role->updatePermissions($this->data['permissions']);
		}

		// Bust the cache
		$this->refreshCacheForever('nova.roles', function () {
			return Role::with('permissions')->get();
		});
	}
}
