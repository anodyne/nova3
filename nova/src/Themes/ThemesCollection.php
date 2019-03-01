<?php

namespace Nova\Themes;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class ThemesCollection extends Collection
{
    /**
     * Get a collection of the theme locations that need to be installed.
     *
     * @return \Illuminate\Support\Collection
     */
    public function toBeInstalled()
    {
        return collect(Storage::disk('themes')->directories())
            ->diff($this->map(function ($theme) {
                return $theme->location;
            }))->filter(function ($location) {
                return Storage::disk('themes')->exists("{$location}/theme.json");
            });
    }
}