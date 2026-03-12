<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Nova\Stories\Models\Story;

class StorySeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        activity()->disableLogging();

        DB::transaction(function () {
            $now = Date::now()->setMicrosecond(0)->toDateTimeString();

            $columns = ['title', 'status', 'parent_id', 'order_column', 'created_at', 'updated_at'];

            $row = function ($modelAttributes, array $overrides = []) use ($columns, $now) {
                $data = Arr::only($modelAttributes, $columns);

                $data['created_at'] = $now;
                $data['updated_at'] = $now;

                foreach ($overrides as $k => $v) {
                    $data[$k] = $v;
                }

                foreach ($columns as $column) {
                    $data[$column] = array_key_exists($column, $data) ? $data[$column] : null;
                }

                return Arr::only($data, $columns);
            };

            $season1 = Story::factory()
                ->ongoing()
                ->create([
                    'title' => 'Season 1',
                    'order_column' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

            $season2 = Story::factory()->upcoming()->make([
                'title' => 'Season 2',
                'order_column' => 2,
            ]);
            DB::table('stories')->insert([
                $row($season2->getAttributes()),
            ]);

            $episode1 = Story::factory()
                ->completed()
                ->create([
                    'title' => 'Episode 1',
                    'parent_id' => $season1->id,
                    'order_column' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

            $episode2 = Story::factory()->current()->make([
                'title' => 'Episode 2',
                'parent_id' => $season1->id,
                'order_column' => 2,
            ]);
            $episode3 = Story::factory()->upcoming()->make([
                'title' => 'Episode 3',
                'parent_id' => $season1->id,
                'order_column' => 3,
            ]);
            DB::table('stories')->insert([
                $row($episode2->getAttributes()),
                $row($episode3->getAttributes()),
            ]);

            $sub1 = Story::factory()->completed()->make([
                'title' => 'Sub-Episode 1',
                'parent_id' => $episode1->id,
                'order_column' => 1,
            ]);
            $sub2 = Story::factory()->completed()->make([
                'title' => 'Sub-Episode 2',
                'parent_id' => $episode1->id,
                'order_column' => 2,
            ]);
            DB::table('stories')->insert([
                $row($sub1->getAttributes()),
                $row($sub2->getAttributes()),
            ]);
        });

        activity()->enableLogging();
    }
}
