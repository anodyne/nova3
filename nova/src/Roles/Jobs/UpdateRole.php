<?php

namespace Nova\Roles\Jobs;

use Bouncer;
use Nova\Roles\Models\Role;
use Illuminate\Bus\Queueable;
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

        $this->syncRoleAbilities();

        return $this->role->refresh();
    }

    protected function syncRoleAbilities()
    {
        $abilities = collect($this->data['abilities'])->map(function ($ability) {
            return Bouncer::ability()->firstOrCreate(['name' => $ability]);
        });

        Bouncer::sync($this->role)->abilities($abilities);
    }
}
