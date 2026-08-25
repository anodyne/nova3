<?php

declare(strict_types=1);

namespace Nova\Departments\Models\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait QueriesUniqueTags
{
    /** @param array<int, string> $tags */
    public function hasTags(array $tags): self
    {
        $versionInfo = DB::versionInfo();

        return match (true) {
            $versionInfo->isPostgres => $this->whereRaw('tags @> ?', [json_encode($tags)]),
            default => $this->where(function ($query) use ($tags): void {
                foreach ($tags as $tag) {
                    $query->whereRaw('JSON_CONTAINS(tags, ?)', [json_encode($tag)]);
                }
            })
        };
    }

    /** @return Collection<string, string> */
    public function uniqueTags(): Collection
    {
        $versionInfo = DB::versionInfo();
        $table = $this->getModel()::table(prefix: true);

        return match (true) {
            $versionInfo->isMysql => $this->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(tag.value, '$')) AS tag")
                ->fromRaw("$table, JSON_TABLE($table.tags, '$[*]' COLUMNS (value JSON PATH '$')) AS tag")
                ->distinct()
                ->pluck('tag', 'tag'),
            $versionInfo->isPostgres => $this->selectRaw('DISTINCT jsonb_array_elements_text(tags) AS tag')->pluck('tag', 'tag'),
            default => $this->pluck('tags')
                ->filter()
                ->flatMap(fn ($tag): array => [$tag[0] => $tag[0]])
                ->unique()
        };
    }
}
