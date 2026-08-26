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
            $table->uuid('id')->primary();
            $table->string('version')->index();
            $table->string('series');
            $table->string('severity');
            $table->longText('description');
            $table->longText('notes')->nullable();
            $table->json('tags')->nullable();
            $table->dateTime('release_date');
            $table->timestamps();
        });

        Schema::create('external_content', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key')->index();
            $table->longText('value');
            $table->timestamps();
        });
    }
};
