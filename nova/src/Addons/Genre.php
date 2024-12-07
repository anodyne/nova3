<?php

declare(strict_types=1);

namespace Nova\Addons;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Nova\Addons\Actions\EnsureSingularActiveGenre;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

abstract class Genre extends BaseAddon
{
    abstract public function departmentAndPositionsData(): array;

    abstract public function rankGroupsAndItemsData(): array;

    abstract public function rankNamesData(): array;

    public function hasRankImages(): bool
    {
        return is_dir(addon_path($this->location.DIRECTORY_SEPARATOR.'assets'));
    }

    public function install(): void
    {
        $this->uninstall();

        if (count($this->departmentAndPositionsData()) > 0) {
            foreach ($this->departmentAndPositionsData() as $department) {
                $positions = data_get($department, 'positions');

                $dept = Department::create(Arr::except($department, 'positions'));

                if (filled($positions)) {
                    $dept->positions()->createMany($positions);
                }
            }
        }

        if (count($this->rankNamesData()) > 0) {
            foreach ($this->rankNamesData() as $rankName) {
                RankName::create($rankName);
            }
        }

        if (count($this->rankGroupsAndItemsData()) > 0) {
            $rankNames = RankName::pluck('id', 'name')->toArray();

            foreach ($this->rankGroupsAndItemsData() as $group) {
                $items = data_get($group, 'items');

                $rankGroup = RankGroup::create(Arr::except($group, 'items'));

                if (filled($items)) {
                    foreach ($items as $item) {
                        $name = data_get($item, 'name');

                        if (filled($name)) {
                            if (array_key_exists($name, $rankNames)) {
                                $rankGroup->ranks()->create(array_merge(
                                    Arr::except($item, 'name'),
                                    ['name_id' => data_get($rankNames, $name)]
                                ));
                            }
                        }
                    }
                }
            }
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

        if ($this->hasRankImages()) {
            $disk = Storage::disk('ranks');

            $disk->delete($disk->allFiles());

            collect($disk->allDirectories())->each(fn (string $dir): bool => $disk->deleteDirectory($dir));
        }
    }
}
