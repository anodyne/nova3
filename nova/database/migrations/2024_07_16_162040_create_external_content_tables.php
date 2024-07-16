<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('external_changelog', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->string('series');
            $table->longText('description');
            $table->text('tags');
            $table->dateTime('release_date');
            $table->timestamps();
        });

        Schema::create('external_content', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->longText('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_changelog');
        Schema::dropIfExists('external_content');
    }
};
