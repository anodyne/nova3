<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $now = Date::now();

            $menuKey = 'public';
            $menuId = DB::table('menus')->where('key', $menuKey)->value('id');

            if (! $menuId) {
                $menuId = Str::uuid7()->toString();

                DB::table('menus')->insert([
                    'id' => $menuId,
                    'name' => 'Public',
                    'key' => $menuKey,
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            } else {
                DB::table('menus')->where('id', $menuId)->update(['updated_at' => $now]);
            }

            $links = [
                ['label' => 'Home', 'page_key' => 'home'],
                ['label' => 'Characters', 'page_key' => 'public.characters'],
                ['label' => 'Stories', 'page_key' => 'public.stories'],
                ['label' => 'Join', 'page_key' => 'public.join'],
                ['label' => 'Contact', 'page_key' => 'public.contact'],
            ];

            $pageIdsByKey = DB::table('pages')
                ->whereIn('key', array_column($links, 'page_key'))
                ->pluck('id', 'key');

            $items = [];
            foreach ($links as $i => $link) {
                $pageId = $pageIdsByKey[$link['page_key']] ?? null;
                if (! $pageId) {
                    continue;
                }

                $items[] = [
                    'id' => Str::uuid7()->toString(),
                    'menu_id' => $menuId,
                    'label' => $link['label'],
                    'link_type' => 'page',
                    'page_id' => $pageId,
                    'url' => null,
                    'order_column' => $i + 1,
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('menu_items')->where('menu_id', $menuId)->delete();

            if (! empty($items)) {
                DB::table('menu_items')->insert($items);
            }
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            $menuId = DB::table('menus')->where('key', 'public')->value('id');

            if ($menuId) {
                DB::table('menu_items')->where('menu_id', $menuId)->delete();
                DB::table('menus')->where('id', $menuId)->delete();
            }
        });
    }
};
