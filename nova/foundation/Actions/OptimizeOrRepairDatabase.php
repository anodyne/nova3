<?php

declare(strict_types=1);

namespace Nova\Foundation\Actions;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class OptimizeOrRepairDatabase
{
    use AsAction;

    public string $commandSignature = 'db:maintenance';

    public string $commandDescription = 'Optimize or repair database tables based on their status';

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

    public function asCommand(Command $command): int
    {
        $this->handle($command);

        $command->info('Database maintenance completed successfully.');

        return Command::SUCCESS;
    }
}
