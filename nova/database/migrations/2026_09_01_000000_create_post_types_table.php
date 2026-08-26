<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->string('key')->unique();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->foreignUuid('role_id')->nullable()->constrained();
            $table->string('status')->index();
            $table->string('visibility')->index();
            $table->json('fields')->nullable();
            $table->json('options')->nullable();
            $table->unsignedBigInteger('order_column')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
