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
            $table->id();
            $table->nullableMorphs('bannable');
            $table->nullableMorphs('created_by');
            $table->text('comment')->nullable();
            $table->string('ip', 45)->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->softDeletes();
            $table->datetimes();
            $table->index('ip');
            $table->index('expired_at');
            $table->json('metas')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('ban.table'));
    }
};
