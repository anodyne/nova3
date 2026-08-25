<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @template TRelatedModel of Model
 * @template TDeclaringModel of Model
 */
class CreateUpdateOrDelete
{
    /** @var HasMany<TRelatedModel, TDeclaringModel> */
    protected HasMany $query;

    /** @var Collection<array-key, Closure|array<string, mixed>> */
    protected Collection $records;

    /**
     * @param  HasMany<TRelatedModel, TDeclaringModel>  $query
     * @param  iterable<array-key, Closure|array<string, mixed>>  $records
     */
    public function __construct(HasMany $query, iterable $records)
    {
        $relatedKeyName = $query->getRelated()->getKeyName();
        $allowedRecordIds = $query->pluck($relatedKeyName);

        $this->query = $query;

        $this->records = collect($records)->filter(
            function ($record) use ($relatedKeyName, $allowedRecordIds): bool {
                $id = $record[$relatedKeyName] ?? null;

                return $id === null || $allowedRecordIds->contains($id);
            }
        );
    }

    public function __invoke(): void
    {
        DB::transaction(function (): void {
            $this->deleteMissingRecords();

            $this->updateOrCreateRecords();
        });
    }

    protected function deleteMissingRecords(): void
    {
        $recordKeyName = $this->query->getRelated()->getKeyName();

        $existingRecordIds = $this->records
            ->pluck($recordKeyName)
            ->filter();

        (clone $this->query)
            ->whereNotIn($recordKeyName, $existingRecordIds)
            ->delete();
    }

    protected function updateOrCreateRecords(): void
    {
        $recordKeyName = $this->query->getRelated()->getKeyName();

        $this->records->each(function (Closure|array $record) use ($recordKeyName): void {
            (clone $this->query)->updateOrCreate([
                $recordKeyName => $record[$recordKeyName] ?? null,
            ], $record);
        });
    }
}
