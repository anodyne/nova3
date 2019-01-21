<?php

namespace Nova\Themes\Jobs;

use Nova\Themes\Theme;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateThemeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $theme;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Theme $theme, array $data)
    {
        $this->theme = $theme;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return tap($this->theme, function ($theme) {
            $theme->update($this->data);
        })->fresh();
    }
}
