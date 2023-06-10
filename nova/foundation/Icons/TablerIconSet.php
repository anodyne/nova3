<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class TablerIconSet extends IconSet
{
    public function icons(): array
    {
        return [
            'add' => 'tabler-square-rounded-plus',
            'alarm' => 'tabler-alarm',
            'alert' => 'tabler-alert-square-rounded',
            'arrow-down' => 'tabler-square-rounded-arrow-down',
            'arrow-left' => 'tabler-square-rounded-arrow-left',
            'arrow-right' => 'tabler-square-rounded-arrow-right',
            'arrow-up' => 'tabler-square-rounded-arrow-up',
            'arrows-sort' => 'tabler-arrows-sort',
            'arrows-sync' => 'tabler-refresh',
            'bell' => 'tabler-bell',
            'bolt' => 'tabler-bolt',
            'book' => 'tabler-notebook',
            'bookmark' => 'tabler-bookmark',
            'bulb' => 'tabler-bulb',
            'calendar' => 'tabler-calendar',
            'characters' => 'tabler-masks-theater',
            'chart' => 'tabler-chart-bar',
            'check' => 'tabler-square-rounded-check',
            'chevron-down' => 'tabler-chevron-down',
            'chevron-left' => 'tabler-chevron-left',
            'chevron-right' => 'tabler-chevron-right',
            'chevron-up' => 'tabler-chevron-up',
            'clock' => 'tabler-clock-hour-3',
            'cloud' => 'tabler-cloud',
            'columns' => 'tabler-columns-3',
            'copy' => 'tabler-copy',
            'dashboard' => 'tabler-gauge',
            'database' => 'tabler-database',
            'device-desktop' => 'tabler-device-desktop',
            'device-mobile' => 'tabler-device-desktop',
            'device-tablet' => 'tabler-device-tablet',
            'dismiss' => 'tabler-x',
            'edit' => 'tabler-pencil',
            'filter' => 'tabler-filter',
            'flag' => 'tabler-flag',
            'folder' => 'tabler-folder',
            'form' => 'tabler-forms',
            'globe' => 'tabler-world',
            'heart' => 'tabler-heart',
            'help' => 'tabler-help-square-rounded',
            'hide' => 'tabler-eye-off',
            'history' => 'tabler-history',
            'home' => 'tabler-home',
            'image' => 'tabler-photo',
            'info' => 'tabler-info-square-rounded',
            'key' => 'tabler-key',
            'layer' => 'tabler-stack-2',
            'link' => 'tabler-link',
            'list' => 'tabler-list',
            'location' => 'tabler-map-pin',
            'lock-closed' => 'tabler-lock',
            'lock-open' => 'tabler-lock-open',
            'login' => 'tabler-login',
            'logout' => 'tabler-logout',
            'mail' => 'tabler-mail',
            'mature' => 'tabler-explicit',
            'menu' => 'tabler-menu-2',
            'moon' => 'tabler-moon-stars',
            'more' => 'tabler-dots',
            'move-down' => 'tabler-arrow-down-square',
            'move-right' => 'tabler-arrow-right-square',
            'move-up' => 'tabler-arrow-up-square',
            'note' => 'tabler-note',
            'number' => 'tabler-123',
            'paint-brush' => 'tabler-brush',
            'prohibited' => 'tabler-ban',
            'rank' => 'tabler-military-rank',
            'remove' => 'tabler-square-rounded-minus',
            'rocket' => 'tabler-rocket',
            'search' => 'tabler-search',
            'send' => 'tabler-send',
            'server' => 'tabler-server',
            'settings' => 'tabler-settings',
            'share' => 'tabler-share-3',
            'shield' => 'tabler-shield',
            'show' => 'tabler-eye',
            'star' => 'tabler-star',
            'sun' => 'tabler-sun',
            'tag' => 'tabler-tag',
            'tags' => 'tabler-tags',
            'thumbs-down' => 'tabler-thumb-down',
            'thumbs-up' => 'tabler-thumb-up',
            'tools' => 'tabler-tool',
            'trash' => 'tabler-trash',
            'user' => 'tabler-user',
            'users' => 'tabler-users',
            'wand' => 'tabler-wand',
            'warning' => 'tabler-alert-triangle',
            'write' => 'tabler-edit',
        ];
    }

    public function name(): string
    {
        return 'Tabler';
    }

    public function prefix(): string
    {
        return 'tabler';
    }
}