<?php

namespace Nova\Themes\Jobs;

use Illuminate\Bus\Queueable;
use Nova\Themes\Models\Theme;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateTheme implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data for updating the theme.
     *
     * @var array
     */
    public $data;

    /**
     * The theme being updated.
     *
     * @var \Nova\Themes\Models\Theme
     */
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
        })->refresh();
    }
}
