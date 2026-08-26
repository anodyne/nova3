<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->string('status')->index();
            $table->json('tags')->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->foreignUuid('department_id')->constrained();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('available')->index();
            $table->string('status')->index();
            $table->json('tags')->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
        });
    }
};
