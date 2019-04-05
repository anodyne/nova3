<?php

namespace Nova\Themes\Concerns;

trait Icons
{
    public function iconMap()
    {
        switch ($this->iconSet) {
            case 'feather':
            default:
                return $this->getFeatherIconMap();
            break;

            case 'fa5':
                return $this->getFontAwesomeIconMap();
            break;
        }
    }

    public function getFeatherIconMap(): array
    {
        return [
            'add' => 'plus-circle',
            'chevron-down' => 'chevron-down',
            'chevron-left' => 'chevron-left',
            'chevron-right' => 'chevron-right',
            'chevron-up' => 'chevron-up',
            'close' => 'x-circle',
            'delete' => 'trash-2',
            'flag' => 'flag',
            'hide' => 'eye-off',
            'home' => 'home',
            'notification' => 'bell',
            'search' => 'search',
            'show' => 'eye',
            'sign-out' => 'log-out',
            'user' => 'user',
        ];
    }

    protected $faSet = 'fas';
    protected $faPrefix = 'fa-';

    public function getFontAwesomeIconMap(): array
    {
        return collect([
            'add' => 'plus-square',
            'chevron-down' => 'chevron-down',
            'chevron-left' => 'chevron-left',
            'chevron-right' => 'chevron-right',
            'chevron-up' => 'chevron-up',
            'close' => 'x-circle',
            'delete' => 'trash',
            'flag' => 'flag',
            'hide' => 'eye-slash',
            'home' => 'home',
            'notification' => 'bell',
            'search' => 'search',
            'show' => 'eye',
            'sign-out' => 'sign-out-alt',
            'user' => 'user',
            ])
            ->map(function ($icon) {
                if (strrpos($icon, ' ') !== false) {
                    return $icon;
                }

                return sprintf('%s %s%s', $this->faSet, $this->faPrefix, $icon);
            })
            ->all();
    }
}
