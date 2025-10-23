<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Nova\Foundation\Nova;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('system_info')->truncate();

        DB::table('system_info')->insert([
            'version' => Nova::filesVersion(),
            'install_date' => Date::now(),
        ]);
    }

    public function down(): void
    {
        DB::table('system_info')->truncate();
    }
};
