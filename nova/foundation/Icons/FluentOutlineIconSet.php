<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class FluentOutlineIconSet extends IconSet
{
    public function icons(): array
    {
        return [
            'add' => 'fluent-o-add-circle',
            'alarm' => 'fluent-o-timer',
            'alert' => 'fluent-o-error-circle',
            'arrow-down' => 'fluent-o-arrow-circle-down',
            'arrow-left' => 'fluent-o-arrow-circle-left',
            'arrow-right' => 'fluent-o-arrow-circle-right',
            'arrow-up' => 'fluent-o-arrow-circle-up',
            'arrows-sort' => 'fluent-o-arrow-sort',
            'arrows-sync' => 'fluent-o-arrow-sync',
            'bell' => 'fluent-o-alert',
            'bolt' => 'fluent-o-flash',
            'book' => 'fluent-o-class',
            'bookmark' => 'fluent-o-bookmark',
            'bulb' => 'fluent-o-lightbulb',
            'calendar' => 'fluent-o-calendar-ltr',
            'characters' => 'fluent-o-emoji-multiple',
            'chart' => 'fluent-o-data-trending',
            'check' => 'fluent-o-checkmark-circle',
            'clock' => 'fluent-o-clock',
            'cloud' => 'fluent-o-cloud',
            'columns' => 'fluent-o-column-triple',
            'copy' => 'fluent-o-square-multiple',
            'dashboard' => 'fluent-o-glance',
            'database' => 'fluent-o-database',
            'device-desktop' => 'fluent-o-desktop',
            'device-mobile' => 'fluent-o-phone',
            'device-tablet' => 'fluent-o-tablet',
            'dismiss' => 'fluent-o-dismiss',
            'edit' => 'fluent-o-edit',
            'filter' => 'fluent-o-filter',
            'flag' => 'fluent-o-flag',
            'folder' => 'fluent-o-folder',
            'form' => 'fluent-o-form',
            'globe' => 'fluent-o-globe',
            'heart' => 'fluent-o-heart',
            'help' => 'fluent-o-question-circle',
            'hide' => 'fluent-o-eye-off',
            'history' => 'fluent-o-history',
            'home' => 'fluent-o-home',
            'image' => 'fluent-o-image',
            'info' => 'fluent-o-info',
            'key' => 'fluent-o-key',
            'layer' => 'fluent-o-layer',
            'link' => 'fluent-o-link',
            'list' => 'fluent-o-text-bullet-list-square',
            'location' => 'fluent-o-location',
            'lock-closed' => 'fluent-o-lock-closed',
            'lock-open' => 'fluent-o-lock-open',
            'login' => 'fluent-o-person-arrow-left',
            'logout' => 'fluent-o-person-arrow-right',
            'mail' => 'fluent-o-mail',
            'mature' => 'fluent-o-rating-mature',
            'menu' => 'fluent-o-navigation',
            'moon' => 'fluent-o-weather-moon',
            'more' => 'fluent-o-more-horizontal',
            'move-down' => 'fluent-o-swipe-down',
            'move-right' => 'fluent-o-swipe-right',
            'move-up' => 'fluent-o-swipe-up',
            'note' => 'fluent-o-note',
            'number' => 'fluent-o-number-symbol-square',
            'paint-brush' => 'fluent-o-paint-brush',
            'prohibited' => 'fluent-o-prohibited',
            'rank' => 'fluent-o-reward',
            'remove' => 'fluent-o-subtract-circle',
            'rocket' => 'fluent-o-rocket',
            'search' => 'fluent-o-search',
            'send' => 'fluent-o-send',
            'server' => 'fluent-o-server',
            'settings' => 'fluent-o-settings',
            'share' => 'fluent-o-share',
            'shield' => 'fluent-o-shield',
            'show' => 'fluent-o-eye',
            'star' => 'fluent-o-star',
            'sun' => 'fluent-o-weather-sunny',
            'tag' => 'fluent-o-tag',
            'tags' => 'fluent-o-tag-multiple',
            'thumbs-down' => 'fluent-o-thumb-dislike',
            'thumbs-up' => 'fluent-o-thumb-like',
            'tools' => 'fluent-o-wrench-screwdriver',
            'trash' => 'fluent-o-delete',
            'user' => 'fluent-o-person',
            'users' => 'fluent-o-people',
            'wand' => 'fluent-o-wand',
            'warning' => 'fluent-o-warning',
            'write' => 'fluent-o-compose',
        ];
    }

    public function name(): string
    {
        return 'Fluent UI System (Outline)';
    }

    public function prefix(): string
    {
        return 'fluent-outline';
    }
}
