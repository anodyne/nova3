<?php

declare(strict_types=1);

namespace Nova\Foundation\Models\Concerns;

use Illuminate\Support\Facades\DB;

trait HasTableHelpers
{
    public static function table(bool $prefix = false): string
    {
        $tableName = with(new static)->getTable();

        if (! $prefix) {
            return $tableName;
        }

        return with(DB::getTablePrefix(), fn ($prefix) => $prefix.$tableName);
    }

    public static function column(string $columnName, ?string $tableAlias = null, bool $prefixTable = false): string
    {
        $tableAlias = $tableAlias ?? static::table($prefixTable);

        return "{$tableAlias}.{$columnName}";
    }

    public static function prefixedColumn(string $columnName, ?string $tableAlias = null): string
    {
        return static::column(
            columnName: $columnName,
            tableAlias: $tableAlias,
            prefixTable: true
        );
    }

    public static function columnAs(string $columnName, string $as, ?string $tableAlias = null, bool $prefixTable = false): string
    {
        $original = self::column($columnName, $tableAlias, $prefixTable);

        return "{$original} as {$as}";
    }

    public static function primaryKey(?string $tableAlias = null, bool $prefixTable = false): string
    {
        return static::column((new static)->primaryKey, $tableAlias, $prefixTable);
    }
}
