<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->foreignUuid('parent_id')->nullable();
            $table->unsignedBigInteger('order_column')->nullable();
            $table->string('status')->index();
            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->text('summary')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->timestamps();
        });
    }
};
