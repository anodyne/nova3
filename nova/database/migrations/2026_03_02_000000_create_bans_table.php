<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('ban.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->nullableUuidMorphs('bannable');
            $table->nullableUuidMorphs('created_by');
            $table->text('comment')->nullable();
            $table->string('ip', 45)->nullable();
            $table->dateTimeTz('expired_at')->nullable();
            $table->json('metas')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('ip');
            $table->index('expired_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('ban.table'));
    }
};
