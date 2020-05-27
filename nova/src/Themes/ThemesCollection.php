<?php

namespace Nova\Themes;

use Nova\Themes\Models\PendingTheme;
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
        $disk = Storage::disk('themes');

        return collect($disk->directories())
            ->diff($this->map(function ($theme) {
                return $theme->location;
            }))
            ->filter(function ($location) use ($disk) {
                return $disk->exists("{$location}/theme.json");
            })->map(function ($location) use ($disk) {
                $theme = json_decode($disk->get("{$location}/theme.json"));

                return $theme;
            });
    }

    public function withPending()
    {
        $disk = Storage::disk('themes');

        $pending = collect($disk->directories())
            ->diff($this->map(function ($theme) {
                return $theme->location;
            }))
            ->filter(function ($location) use ($disk) {
                return $disk->exists("{$location}/theme.json");
            })->map(function ($location) use ($disk) {
                return json_decode($disk->get("{$location}/theme.json"), true);
            })->mapInto(PendingTheme::class);

        return $this->merge($pending)->sortBy('name');
    }
}
