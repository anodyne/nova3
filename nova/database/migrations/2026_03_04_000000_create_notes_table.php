<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->foreignUuid('user_id')->constrained();
            $table->string('title')->index();
            $table->longText('content')->nullable();
            $table->timestamps();
        });
    }
};
