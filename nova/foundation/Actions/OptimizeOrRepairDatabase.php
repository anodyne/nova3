<?php

declare(strict_types=1);

namespace Nova\Foundation\Actions;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OptimizeOrRepairDatabase extends Action
{
    public function handle(?Command $command = null): void
    {
        $tables = DB::select('SHOW TABLE STATUS');

        foreach ($tables as $table) {
            $tableName = $table->Name;
            $engine = $table->Engine;
            $dataFree = $table->Data_free; // Amount of fragmented space
            $comment = $table->Comment; // MyISAM crash details, if any

            if ($engine === 'MyISAM' && str_contains(strtolower($comment), 'crashed')) {
                // Table needs repair
                $command?->info("Repairing table: {$tableName}");
                DB::statement("REPAIR TABLE {$tableName}");
            } elseif ($dataFree > 0) {
                // Table is fragmented and needs optimization
                $command?->info("Optimizing table: {$tableName}");
                DB::statement("OPTIMIZE TABLE {$tableName}");
            } else {
                // No maintenance needed
                $command?->info("No action needed for table: {$tableName}");
            }
        }
    }
}
