<?php

namespace Nova\Roles\Jobs;

use Illuminate\Bus\Queueable;
use Silber\Bouncer\Database\Role;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateRole implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $role;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Role $role, array $data)
    {
        $this->role = $role;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->role->update($this->data);

        return $this->role->fresh();
    }
}
