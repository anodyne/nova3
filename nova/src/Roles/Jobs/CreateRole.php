<?php

namespace Nova\Roles\Jobs;

use Bouncer;
use Nova\Roles\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateRole implements ShouldQueue
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
        $role = Bouncer::role()->firstOrCreate([
            'name' => data_get($this->data, 'name'),
            'title' => data_get($this->data, 'title'),
        ]);

        $this->syncRoleAbilities($role);

        return $role->fresh();
    }

    protected function syncRoleAbilities(Role $role)
    {
        $abilities = collect($this->data['abilities'])->map(function ($ability) {
            return Bouncer::ability()->firstOrCreate(['name' => $ability]);
        });

        Bouncer::sync($role)->abilities($abilities);
    }
}
