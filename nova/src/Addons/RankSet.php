<?php

declare(strict_types=1);

namespace Nova\Addons;

use Nova\Addons\Concerns\MovesRankImages;

abstract class RankSet extends BaseAddon
{
    use MovesRankImages;

    public function append(): void
    {
        $this->appendImages();
    }

    public function install(): void
    {
        $this->installRankImages();
    }

    public function replace(): void
    {
        $this->replaceImages();
    }

    public function uninstall(): void
    {
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
