<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Menus\Enums\LinkTarget;
use Nova\Menus\Enums\MenuStatus;
use Nova\Menus\Models\Menu;
use Nova\Pages\Models\Page;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key');
            $table->string('status')->default(MenuStatus::Active->value);
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Menu::class);
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('label');
            $table->string('icon')->nullable();
            $table->string('link_type');
            $table->foreignIdFor(Page::class)->nullable();
            $table->string('url')->nullable();
            $table->string('target')->default(LinkTarget::Self);
            $table->string('status')->default(MenuStatus::Active->value);
            $table->integer('order_column')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');
    }
};
