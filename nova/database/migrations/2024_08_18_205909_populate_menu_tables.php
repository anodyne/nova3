<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Menus\Enums\LinkType;
use Nova\Menus\Models\Menu;
use Nova\Pages\Models\Page;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        activity()->disableLogging();

        $menu = Menu::create(['name' => 'Public', 'key' => 'public']);

        $menu->items()->createMany([
            ['label' => 'Home', 'link_type' => LinkType::Url, 'url' => '/'],
            ['label' => 'Join', 'link_type' => LinkType::Page, 'page_id' => Page::key('join.show')->first()->id],
            ['label' => 'Contact', 'link_type' => LinkType::Page, 'page_id' => Page::key('contact.show')->first()->id],
        ]);

        activity()->enableLogging();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
