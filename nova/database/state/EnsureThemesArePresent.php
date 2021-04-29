<?php

namespace Database\State;

use Illuminate\Support\Facades\DB;

class EnsureThemesArePresent
{
    public function __invoke()
    {
        if ($this->present()) {
            return;
        }

        DB::table('themes')->insert([
            ['name' => 'Pulsar', 'location' => 'pulsar', 'preview' => 'preview.jpg'],
            ['name' => 'Titan', 'location' => 'titan', 'preview' => 'preview.jpg'],
        ]);
    }

    private function present(): bool
    {
        return DB::table('themes')->count() > 0;
    }
}
