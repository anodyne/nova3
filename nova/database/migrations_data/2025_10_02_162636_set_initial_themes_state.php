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
        $themes = [
            [
                'id' => Str::uuid7()->toString(),
                'name' => 'Pulsar',
                'location' => 'Pulsar',
                'version' => '3.0',
                'credits' => null,
                'preview' => 'preview.png',
                'status' => 'active',
                'settings' => [
                    'fonts' => [
                        'headerProvider' => 'local',
                        'headerFamily' => 'Inter',
                        'bodyProvider' => 'local',
                        'bodyFamily' => 'Inter',
                    ],
                ],
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            ],
        ];

        $rows = array_map(function (array $theme) {
            foreach ($theme as $key => $value) {
                if (is_array($value)) {
                    $theme[$key] = json_encode(
                        $value,
                        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
                    );
                }
            }

            return $theme;
        }, $themes);

        DB::transaction(fn () => DB::table('themes')->insert($rows));
    }
};
