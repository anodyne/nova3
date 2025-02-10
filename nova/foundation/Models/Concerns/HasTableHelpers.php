<?php

declare(strict_types=1);

namespace Nova\Foundation\Models\Concerns;

use Illuminate\Support\Facades\DB;

trait HasTableHelpers
{
    public static function table(): string
    {
        return with(
            DB::getTablePrefix(),
            fn ($prefix) => $prefix.with(new static)->getTable()
        );
    }

    public static function column(string $columnName, ?string $tableAlias = null): string
    {
        $tableAlias = $tableAlias ?? static::table();

        return "{$tableAlias}.{$columnName}";
    }

    public static function columnAs(string $columnName, string $as, ?string $tableAlias = null): string
    {
        $original = self::column($columnName, $tableAlias);

        return "{$original} as {$as}";
    }

    public static function primaryKey(?string $tableAlias = null): string
    {
        return static::column((new static)->primaryKey, $tableAlias);
    }
}
