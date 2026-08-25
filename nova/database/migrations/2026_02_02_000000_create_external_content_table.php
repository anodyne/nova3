<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('external_changelog', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->string('series');
            $table->string('severity');
            $table->longText('description');
            $table->longText('notes')->nullable();
            $table->json('tags')->nullable();
            $table->dateTime('release_date');
            $table->datetimes();
        });

        Schema::create('external_content', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index();
            $table->longText('value');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_changelog');
        Schema::dropIfExists('external_content');
    }
};
