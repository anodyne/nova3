<?php

namespace Nova\Roles\Jobs;

use Bouncer;
use Illuminate\Bus\Queueable;
use Silber\Bouncer\Database\Role;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Nova\Foundation\WordGenerator;

class DuplicateRole implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $originalRole;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Role $originalRole)
    {
        $this->originalRole = $originalRole;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $role = $this->originalRole->replicate();

        $role->name = implode('-', (new WordGenerator)->words(2));
        $role->title = "Copy of {$role->title}";

        $role->save();

        Bouncer::sync($role)->abilities($this->originalRole->getAbilities());

        return $role->fresh();
    }
}
