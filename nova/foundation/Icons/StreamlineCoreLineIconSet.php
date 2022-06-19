<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class StreamlineCoreLineIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'add-square',
            'alert' => 'alert-warning-circle',
            'arrow-right' => 'arrows-right',
            'arrow-sort' => 'arrows-vertical',
            'book' => 'file-bookmark',
            'calendar' => 'calendar',
            'check' => 'check-square',
            'clock' => 'time-clock',
            'close' => 'delete-square',
            'copy' => 'edit-select-front',
            'dashboard' => 'dashboard',
            'delete' => 'delete-bin',
            'desktop' => 'computer-monitor',
            'drop' => 'weather-rain-drop',
            'edit' => 'edit-pencil',
            'email' => 'mail',
            'emoji' => 'theater-mask',
            'filter' => 'filter',
            'folder' => 'folder',
            'hide' => 'view-off',
            'image' => 'picture-landscape',
            'info' => 'alert-info',
            'lightbulb' => 'light-bulb',
            'list' => 'list-bullets',
            'location' => 'location',
            'lock' => 'lock',
            'mature' => 'rating-mature',
            'menu' => 'menu',
            'moon' => 'moon',
            'move-down' => 'arrows-move-down',
            'move-right' => 'arrows-move-right',
            'move-up' => 'arrows-move-up',
            'note' => 'note-pad-text',
            'notification' => 'alert-bell',
            'number' => 'hashtag',
            'paint-bucket' => 'edit-brush',
            'preferences' => 'setting-slider-horizontal',
            'remove' => 'block',
            'search' => 'search',
            'settings' => 'setting-cog',
            'show' => 'view',
            'sign-in' => 'login',
            'sign-out' => 'logout',
            'star' => 'star',
            'start' => 'control-play',
            'stop' => 'control-stop',
            'sun' => 'sun',
            'timer' => 'time-timer',
            'user' => 'user-single',
            'user-add' => 'user-add',
            'users' => 'user-multiple',
            'warning' => 'alert-warning-triangle',
            'wrench' => 'wrench',
            'write' => 'edit-write',
        ];
    }

    public function name(): string
    {
        return 'Streamline Core Line';
    }

    public function prefix(): string
    {
        return 'scl';
    }
}
