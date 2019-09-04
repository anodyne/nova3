<?php

namespace Nova\Roles\Jobs;

use Bouncer;
use Nova\Roles\Models\Role;
use Illuminate\Bus\Queueable;
use Nova\Foundation\WordGenerator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
