<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Menus\Enums\LinkTarget;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique();
            $table->string('status')->default(BasicStatus::Active->value)->index();
            $table->datetimes();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained();
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('label');
            $table->string('icon')->nullable();
            $table->string('link_type');
            $table->foreignId('page_id')->nullable()->constrained();
            $table->string('url')->nullable();
            $table->string('target')->default(LinkTarget::Self);
            $table->string('status')->default(BasicStatus::Active->value)->index();
            $table->integer('order_column')->nullable();
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');
    }
};
