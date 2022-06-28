<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class FluentIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'add-circle',
            'alert' => 'error-circle',
            'arrow-down' => 'arrow-circle-down',
            'arrow-left' => 'arrow-circle-left',
            'arrow-right' => 'arrow-circle-right',
            'arrow-up' => 'arrow-circle-up',
            'arrow-sort' => 'arrow-sort',
            'book' => 'class',
            'bookmark' => 'bookmark',
            'calendar' => 'calendar-ltr',
            'chart' => 'data-trending',
            'chat' => 'chat-multiple',
            'check' => 'checkmark-circle',
            'clock' => 'clock',
            'close' => 'dismiss',
            'cloud' => 'cloud',
            'copy' => 'square-multiple',
            'dashboard' => 'glance',
            'database' => 'database',
            'delete' => 'delete',
            'desktop' => 'desktop',
            'drop' => 'drop',
            'edit' => 'edit',
            'email' => 'mail',
            'emoji' => 'emoji-multiple',
            'filter' => 'filter',
            'flag' => 'flag',
            'flash' => 'flash',
            'folder' => 'folder',
            'form' => 'form',
            'globe' => 'globe',
            'heart' => 'heart',
            'hide' => 'eye-off',
            'history' => 'history',
            'home' => 'home',
            'image' => 'image',
            'info' => 'info',
            'layer' => 'layer',
            'lightbulb' => 'lightbulb',
            'link' => 'link',
            'list' => 'text-bullet-list-ltr',
            'location' => 'location',
            'lock' => 'lock-closed',
            'mature' => 'rating-mature',
            'menu' => 'navigation',
            'moon' => 'weather-moon',
            'move-down' => 'swipe-down',
            'move-right' => 'swipe-right',
            'move-up' => 'swipe-up',
            'note' => 'note',
            'notification' => 'alert',
            'paint-bucket' => 'paint-bucket',
            'phone' => 'phone',
            'prohibited' => 'prohibited',
            'question' => 'question-circle',
            'remove' => 'subtract-circle',
            'rocket' => 'rocket',
            'search' => 'search',
            'send' => 'send',
            'server' => 'server',
            'settings' => 'settings',
            'share' => 'share',
            'shield' => 'shield',
            'show' => 'eye',
            'sign-in' => 'person-arrow-left',
            'sign-out' => 'person-arrow-right',
            'star' => 'star',
            'sun' => 'weather-sunny',
            'sync' => 'arrow-sync',
            'tablet' => 'tablet',
            'tag' => 'tag',
            'tags' => 'tag-multiple',
            'thumbs-down' => 'thumb-dislike',
            'thumbs-up' => 'thumb-like',
            'timer' => 'timer',
            'unlock' => 'lock-open',
            'user' => 'person',
            'users' => 'people',
            'warning' => 'warning',
            'wrench' => 'wrench',
            'write' => 'compose',
        ];
    }

    public function name(): string
    {
        return 'Fluent UI System Icons';
    }

    public function prefix(): string
    {
        return 'fluent';
    }
}
