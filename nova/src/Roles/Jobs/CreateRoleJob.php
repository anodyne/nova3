<?php

namespace Nova\Roles\Jobs;

use Bouncer;
use Illuminate\Bus\Queueable;
use Silber\Bouncer\Database\Role;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateRoleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $role = $this->createRole();

        $this->assignAbilitiesToRole($role);

        return $role->fresh();
    }

    protected function createRole()
    {
        return Bouncer::role()->firstOrCreate([
            'name' => data_get($this->data, 'name'),
            'title' => data_get($this->data, 'title'),
        ]);
    }

    protected function assignAbilitiesToRole(Role $role)
    {
        if (! array_key_exists('abilities', $this->data)) {
            return;
        }
        collect(data_get($this->data, 'abilities'))
            ->each(function ($ability) use ($role) {
                $permission = Bouncer::ability()->firstOrCreate(['name' => $ability]);

                Bouncer::allow($role)->to($permission);
            });
    }
}
