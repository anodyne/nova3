<?php

namespace Nova\Themes\Jobs;

use Illuminate\Bus\Queueable;
use Nova\Themes\Models\Theme;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteTheme implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $theme;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return tap($this->theme, function ($theme) {
            $theme->delete();
        });
    }
}
