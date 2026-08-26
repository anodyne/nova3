<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Nova\Foundation\Nova;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('system_info')->truncate();

        DB::table('system_info')->insert([
            'id' => Str::uuid7()->toString(),
            'version' => Nova::filesVersion(),
            'install_date' => Date::now(),
        ]);
    }
};
