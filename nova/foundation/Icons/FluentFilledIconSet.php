<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class FluentFilledIconSet extends IconSet
{
    public function icons(): array
    {
        return [
            'add' => 'fluent-f-add-circle',
            'alarm' => 'fluent-f-timer',
            'alert' => 'fluent-f-error-circle',
            'arrow-down' => 'fluent-f-arrow-circle-down',
            'arrow-left' => 'fluent-f-arrow-circle-left',
            'arrow-right' => 'fluent-f-arrow-circle-right',
            'arrow-up' => 'fluent-f-arrow-circle-up',
            'arrows-sort' => 'fluent-f-arrow-sort',
            'arrows-sync' => 'fluent-f-arrow-sync',
            'bell' => 'fluent-f-alert',
            'bolt' => 'fluent-f-flash',
            'book' => 'fluent-f-class',
            'bookmark' => 'fluent-f-bookmark',
            'bulb' => 'fluent-f-lightbulb',
            'calendar' => 'fluent-f-calendar-ltr',
            'characters' => 'fluent-f-emoji-multiple',
            'chart' => 'fluent-f-data-trending',
            'check' => 'fluent-f-checkmark-circle',
            'clock' => 'fluent-f-clock',
            'cloud' => 'fluent-f-cloud',
            'columns' => 'fluent-f-column-triple',
            'copy' => 'fluent-f-square-multiple',
            'dashboard' => 'fluent-f-glance',
            'database' => 'fluent-f-database',
            'device-desktop' => 'fluent-f-desktop',
            'device-mobile' => 'fluent-f-phone',
            'device-tablet' => 'fluent-f-tablet',
            'dismiss' => 'fluent-f-dismiss',
            'edit' => 'fluent-f-edit',
            'filter' => 'fluent-f-filter',
            'flag' => 'fluent-f-flag',
            'folder' => 'fluent-f-folder',
            'form' => 'fluent-f-form',
            'globe' => 'fluent-f-globe',
            'heart' => 'fluent-f-heart',
            'help' => 'fluent-f-question-circle',
            'hide' => 'fluent-f-eye-off',
            'history' => 'fluent-f-history',
            'home' => 'fluent-f-home',
            'image' => 'fluent-f-image',
            'info' => 'fluent-f-info',
            'key' => 'fluent-f-key',
            'layer' => 'fluent-f-layer',
            'link' => 'fluent-f-link',
            'list' => 'fluent-f-text-bullet-list-square',
            'location' => 'fluent-f-location',
            'lock-closed' => 'fluent-f-lock-closed',
            'lock-open' => 'fluent-f-lock-open',
            'login' => 'fluent-f-person-arrow-left',
            'logout' => 'fluent-f-person-arrow-right',
            'mail' => 'fluent-f-mail',
            'mature' => 'fluent-f-rating-mature',
            'menu' => 'fluent-f-navigation',
            'moon' => 'fluent-f-weather-moon',
            'more' => 'fluent-f-more-horizontal',
            'move-down' => 'fluent-f-swipe-down',
            'move-right' => 'fluent-f-swipe-right',
            'move-up' => 'fluent-f-swipe-up',
            'note' => 'fluent-f-note',
            'number' => 'fluent-f-number-symbol-square',
            'paint-brush' => 'fluent-f-paint-brush',
            'prohibited' => 'fluent-f-prohibited',
            'rank' => 'fluent-f-reward',
            'remove' => 'fluent-f-subtract-circle',
            'rocket' => 'fluent-f-rocket',
            'search' => 'fluent-f-search',
            'send' => 'fluent-f-send',
            'server' => 'fluent-f-server',
            'settings' => 'fluent-f-settings',
            'share' => 'fluent-f-share',
            'shield' => 'fluent-f-shield',
            'show' => 'fluent-f-eye',
            'star' => 'fluent-f-star',
            'sun' => 'fluent-f-weather-sunny',
            'tag' => 'fluent-f-tag',
            'tags' => 'fluent-f-tag-multiple',
            'thumbs-down' => 'fluent-f-thumb-dislike',
            'thumbs-up' => 'fluent-f-thumb-like',
            'tools' => 'fluent-f-wrench-screwdriver',
            'trash' => 'fluent-f-delete',
            'user' => 'fluent-f-person',
            'users' => 'fluent-f-people',
            'wand' => 'fluent-f-wand',
            'warning' => 'fluent-f-warning',
            'write' => 'fluent-f-compose',
        ];
    }

    public function name(): string
    {
        return 'Fluent UI System (Filled)';
    }

    public function prefix(): string
    {
        return 'fluent-filled';
    }
}
