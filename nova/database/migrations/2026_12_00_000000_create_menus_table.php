<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('key')->unique();
            $table->string('status')->index();
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('menu_id')->constrained();
            $table->uuid('parent_id')->nullable()->constrained('menu_items');
            $table->string('label');
            $table->string('icon')->nullable();
            $table->string('link_type');
            $table->foreignUuid('page_id')->nullable()->constrained();
            $table->string('url')->nullable();
            $table->string('target')->default('_self');
            $table->string('status')->default('active')->index();
            $table->unsignedBigInteger('order_column')->nullable();
            $table->timestamps();
        });
    }
};
