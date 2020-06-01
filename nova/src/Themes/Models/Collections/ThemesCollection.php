<?php

namespace Nova\Themes\Models\Collections;

use Nova\Themes\Models\PendingTheme;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class ThemesCollection extends Collection
{
    public function onlyPending()
    {
        $disk = Storage::disk('themes');

        return collect($disk->directories())
            ->diff($this->map(function ($theme) {
                return $theme->location;
            }))
            ->filter(function ($location) use ($disk) {
                return $disk->exists("{$location}/theme.json");
            })->map(function ($location) use ($disk) {
                return json_decode($disk->get("{$location}/theme.json"), true);
            })->mapInto(PendingTheme::class)
            ->sortBy('name');
    }

    public function withPending()
    {
        return $this->merge($this->onlyPending())->sortBy('name');
    }
}
