<?php

declare(strict_types=1);

namespace Nova\Foundation\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * @phpstan-require-extends Model
 */
trait HasTableHelpers
{
    /**
     * @return literal-string
     */
    public static function column(string $columnName, ?string $tableAlias = null, bool $prefixTable = false): string
    {
        $tableAlias ??= static::table($prefixTable);

        self::assertSafeSqlIdentifier($tableAlias);
        self::assertSafeSqlIdentifier($columnName);

        return "{$tableAlias}.{$columnName}";
    }

    /**
     * @return literal-string
     */
    public static function columnAs(string $columnName, string $as, ?string $tableAlias = null, bool $prefixTable = false): string
    {
        $original = static::column($columnName, $tableAlias, $prefixTable);
        self::assertSafeSqlIdentifier($as);

        return "{$original} as {$as}";
    }

    public static function model(): Model
    {
        return static::query()->getModel();
    }

    /**
     * @return literal-string
     */
    public static function prefixedColumn(string $columnName, ?string $tableAlias = null): string
    {
        return static::column(
            columnName: $columnName,
            tableAlias: $tableAlias,
            prefixTable: true
        );
    }

    /**
     * @return literal-string
     */
    public static function primaryKey(?string $tableAlias = null, bool $prefixTable = false): string
    {
        return static::column(
            static::model()->getKeyName(),
            $tableAlias,
            $prefixTable
        );
    }

    /** @return literal-string */
    public static function table(bool $prefix = false): string
    {
        $model = static::model();
        $table = $model->getTable();

        $tableName = $prefix
            ? $model->getConnection()->getTablePrefix().$table
            : $table;

        self::assertSafeSqlIdentifier($tableName);

        return $tableName;
    }

    /** @phpstan-assert literal-string $identifier */
    private static function assertSafeSqlIdentifier(string $identifier): void
    {
        if (preg_match('/\A[a-zA-Z_][a-zA-Z0-9_.]*\z/', $identifier) !== 1) {
            throw new InvalidArgumentException("Invalid SQL identifier [{$identifier}].");
        }
    }
}
