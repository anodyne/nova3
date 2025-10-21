<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('upgrade', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedBigInteger('old_id');
            $table->unsignedBigInteger('new_id');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('upgrade');
    }
};
