<?php

use Database\State\Pages;
use Illuminate\Database\Migrations\Migration;

class PopulateInitialPages extends Migration
{
    public function up(): void
    {
        Pages::create();
    }

    public function down(): void
    {
        Pages::delete();
    }
}
