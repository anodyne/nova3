<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class CreateUpdateOrDelete
{
    protected $query;

    protected $records;

    public function __construct(HasMany $query, iterable $records)
    {
        $relatedKeyName = $query->getRelated()->getKeyName();
        $allowedRecordIds = $query->pluck($relatedKeyName);

        $this->query = $query;

        $this->records = collect($records)->filter(
            function ($record) use ($relatedKeyName, $allowedRecordIds) {
                $id = $record[$relatedKeyName] ?? null;

                return $id === null || $allowedRecordIds->contains($id);
            }
        );
    }

    public function __invoke()
    {
        DB::transaction(function () {
            $this->deleteMissingRecords();

            $this->updateOrCreateRecords();
        });
    }

    protected function deleteMissingRecords()
    {
        $recordKeyName = $this->query->getRelated()->getKeyName();

        $existingRecordIds = $this->records
            ->pluck($recordKeyName)
            ->filter();

        (clone $this->query)
            ->whereNotIn($recordKeyName, $existingRecordIds)
            ->delete();
    }

    protected function updateOrCreateRecords()
    {
        $recordKeyName = $this->query->getRelated()->getKeyName();

        $this->records->each(function ($record) use ($recordKeyName) {
            (clone $this->query)->updateOrCreate([
                $recordKeyName => $record[$recordKeyName] ?? null,
            ], $record);
        });
    }
}
