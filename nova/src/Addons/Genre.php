<?php

declare(strict_types=1);

namespace Nova\Addons;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Nova\Addons\Actions\EnsureSingularActiveGenre;
use Nova\Addons\Concerns\MovesRankImages;
use Nova\Departments\Actions\CreateDepartment;
use Nova\Departments\Actions\CreatePosition;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Ranks\Actions\CreateRankGroup;
use Nova\Ranks\Actions\CreateRankItem;
use Nova\Ranks\Actions\CreateRankName;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Data\RankItemData;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

/**
 * @phpstan-type PhpStanPositionData array{
 *     name: string,
 *     description: string
 * }
 * @phpstan-type PhpStanDepartmentData array{
 *     name: string,
 *     description: string,
 *     positions: list<PhpStanPositionData>
 * }
 * @phpstan-type PhpStanRankItemData array{
 *     name: string,
 *     base_image: string,
 *     overlay_image: string
 * }
 * @phpstan-type PhpStanRankGroupData array{
 *     name: string,
 *     items: list<PhpStanRankItemData>
 * }
 */
abstract class Genre extends BaseAddon
{
    use MovesRankImages;

    /** @return list<PhpStanDepartmentData> */
    abstract public function departmentAndPositionsData(): array;

    /** @return list<PhpStanRankGroupData> */
    abstract public function rankGroupsAndItemsData(): array;

    /**
     * @return list<array{name: string}>
     */
    abstract public function rankNamesData(): array;

    public function install(): void
    {
        $this->uninstall();

        foreach ($this->departmentAndPositionsData() as $department) {
            $positions = data_get($department, 'positions');
            $departmentData = Arr::except($department, 'positions');

            if (is_string($tags = data_get($departmentData, 'tags'))) {
                $departmentData['tags'] = array_map(trim(...), explode(',', $tags));
            }

            $dept = CreateDepartment::run(
                DepartmentData::from($departmentData)
            );

            foreach ($positions as $position) {
                CreatePosition::run(
                    PositionData::from([
                        ...$position,
                        'department_id' => $dept->id,
                    ])
                );
            }
        }

        foreach ($this->rankNamesData() as $rankName) {
            CreateRankName::run(RankNameData::from($rankName));
        }

        if (count($this->rankGroupsAndItemsData()) > 0) {
            $rankNames = RankName::pluck('id', 'name')->toArray();

            foreach ($this->rankGroupsAndItemsData() as $group) {
                $items = data_get($group, 'items');

                $rankGroup = CreateRankGroup::run(RankGroupData::from(Arr::except($group, 'items')));

                foreach ($items as $item) {
                    $name = data_get($item, 'name');

                    if (filled($name)) {
                        if (array_key_exists($name, $rankNames)) {
                            CreateRankItem::run(
                                RankItemData::from([
                                    ...Arr::except($item, 'name'),
                                    'name_id' => data_get($rankNames, $name),
                                    'group_id' => $rankGroup->id,
                                ])
                            );
                        }
                    }
                }
            }
        }

        if ($this->addonDisk()->exists('ranks')) {
            $this->installRankImages();
        }

        EnsureSingularActiveGenre::run($this->getModel());
    }

    public function uninstall(): void
    {
        Schema::disableForeignKeyConstraints();

        try {
            RankGroup::query()->delete();
            RankItem::query()->delete();
            RankName::query()->delete();
            Position::query()->delete();
            Department::query()->delete();
        } finally {
            Schema::enableForeignKeyConstraints();
        }

        $this->uninstallRankImages();
    }

    final public function runScript(string $name): void
    {
        if (method_exists($this, $name)) {
            $this->{$name}();

            $event = "ran-{$name}";

            activity()
                ->performedOn($this->getModel())
                ->event($event)
                ->log($event);
        }
    }
}
