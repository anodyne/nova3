<?php

namespace Nova\Authorization\Jobs;

use Illuminate\Bus\Queueable;
use Silber\Bouncer\Database\Role;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteRoleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $role;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->role->delete();

        return $this->role;
    }
}
