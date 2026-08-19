<?php

declare(strict_types=1);

namespace Nova\Foundation\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use LogicException;

/**
 * @phpstan-require-extends Model
 */
trait HasTableHelpers
{
    public static function column(string $columnName, ?string $tableAlias = null, bool $prefixTable = false): string
    {
        $tableAlias ??= static::table($prefixTable);

        return "{$tableAlias}.{$columnName}";
    }

    public static function columnAs(string $columnName, string $as, ?string $tableAlias = null, bool $prefixTable = false): string
    {
        $original = static::column($columnName, $tableAlias, $prefixTable);

        return "{$original} as {$as}";
    }

    public static function model(): static
    {
        $model = static::query()->getModel();

        if (! $model instanceof static) {
            throw new LogicException('The query builder model must match '.static::class.'.');
        }

        return $model;
    }

    public static function prefixedColumn(string $columnName, ?string $tableAlias = null): string
    {
        return static::column(
            columnName: $columnName,
            tableAlias: $tableAlias,
            prefixTable: true
        );
    }

    public static function primaryKey(?string $tableAlias = null, bool $prefixTable = false): string
    {
        return static::column(
            static::model()->getKeyName(),
            $tableAlias,
            $prefixTable
        );
    }

    public static function table(bool $prefix = false): string
    {
        $model = static::model();
        $table = $model->getTable();

        return $prefix
            ? $model->getConnection()->getTablePrefix().$table
            : $table;
    }
}
