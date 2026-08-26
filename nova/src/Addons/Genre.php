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
 * @phpstan-type PositionData array{
 *     name: string,
 *     description: string
 * }
 * @phpstan-type DepartmentData array{
 *     name: string,
 *     description: string,
 *     positions: list<PositionData>
 * }
 * @phpstan-type RankItemData array{
 *     name: string,
 *     base_image: string,
 *     overlay_image: string
 * }
 * @phpstan-type RankGroupData array{
 *     name: string,
 *     items: list<RankItemData>
 * }
 */
abstract class Genre extends BaseAddon
{
    use MovesRankImages;

    /** @return list<DepartmentData> */
    abstract public function departmentAndPositionsData(): array;

    /** @return list<RankGroupData> */
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

            $dept = CreateDepartment::run(
                DepartmentData::from(Arr::except($department, 'positions'))
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

        RankGroup::query()->truncate();
        RankItem::query()->truncate();
        RankName::query()->truncate();
        Position::query()->truncate();
        Department::query()->truncate();

        Schema::enableForeignKeyConstraints();

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
