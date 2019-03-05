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
        $disk = Storage::disk('themes');

        return collect($disk->directories())
            ->diff($this->map(function ($theme) {
                return $theme->location;
            }))
            ->filter(function ($location) use ($disk) {
                return $disk->exists("{$location}/theme.json");
            })->map(function ($location) use ($disk) {
                $theme = json_decode($disk->get("{$location}/theme.json"));

                return [
                    'name' => $theme->name,
                    'location' => $location,
                    'credits' => $theme->credits,
                ];
            });
    }
}
