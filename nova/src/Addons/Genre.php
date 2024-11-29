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

    abstract public function rankNameData(): array;

    public function hasRankImages(): bool
    {
        return is_dir(addon_path($this->location.DIRECTORY_SEPARATOR.'assets'));
    }

    public function install(): void
    {
        $this->uninstall();

        foreach ($this->departmentAndPositionsData() as $department) {
            $positions = data_get($department, 'positions');

            $dept = Department::create(Arr::except($department, 'positions'));

            if (filled($positions)) {
                $dept->positions()->createMany($positions);
            }
        }

        foreach ($this->rankNameData() as $rankName) {
            RankName::create($rankName);
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
