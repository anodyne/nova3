<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class FontAwesomeSolidIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'circle-plus-solid',
            'alert' => 'circle-exclamation-solid',
            'arrow-down' => 'circle-arrow-down-solid',
            'arrow-left' => 'circle-arrow-left-solid',
            'arrow-right' => 'circle-arrow-right-solid',
            'arrow-up' => 'circle-arrow-up-solid',
            'arrow-sort' => 'arrow-down-short-wide-solid',
            'book' => 'book-solid',
            'bookmark' => 'bookmark-solid',
            'calendar' => 'calendar-solid',
            'chart' => 'chart-line-solid',
            'chat' => 'comments-solid',
            'check' => 'circle-check-solid',
            'clock' => 'clock-solid',
            'close' => 'circle-xmark-solid',
            'cloud' => 'cloud-solid',
            'copy' => 'clone-solid',
            'dashboard' => 'gauge-high-solid',
            'database' => 'database-solid',
            'delete' => 'trash-solid',
            'desktop' => 'desktop-solid',
            'drop' => 'droplet-solid',
            'edit' => 'pen-solid',
            'email' => 'envelope-solid',
            'emoji' => 'masks-theater-solid',
            'filter' => 'filter-solid',
            'flag' => 'flag-solid',
            'flash' => 'bolt-solid',
            'folder' => 'folder-open-solid',
            'form' => 'rectangle-list-solid',
            'globe' => 'globe-solid',
            'heart' => 'heart-solid',
            'hide' => 'eye-slash-solid',
            'history' => 'clock-rotate-left-solid',
            'home' => 'house-chimney-solid',
            'image' => 'image-solid',
            'info' => 'circle-info-solid',
            'layer' => 'layer-group-solid',
            'lightbulb' => 'lightbulb-solid',
            'link' => 'link-solid',
            'list' => 'list-solid',
            'location' => 'location-dot-solid',
            'lock' => 'lock-solid',
            'mature' => 'shield-solid',
            'menu' => 'bars-solid',
            'moon' => 'moon-solid',
            'move-down' => 'angles-down-solid',
            'move-right' => 'angles-right-solid',
            'move-up' => 'angles-up-solid',
            'note' => 'note-sticky-solid',
            'notification' => 'bell-solid',
            'paint-bucket' => 'fill-drip-solid',
            'phone' => 'mobile-solid',
            'prohibited' => 'ban-solid',
            'question' => 'circle-question-solid',
            'remove' => 'circle-minus-solid',
            'rocket' => 'rocket-solid',
            'search' => 'magnifying-glass-solid',
            'send' => 'paper-plane-solid',
            'server' => 'server-solid',
            'settings' => 'gear-solid',
            'share' => 'arrow-up-right-from-square-solid',
            'shield' => 'shield-solid',
            'show' => 'eye-solid',
            'sign-in' => 'arrow-right-to-bracket-solid',
            'sign-out' => 'arrow-right-from-bracket-solid',
            'star' => 'star-solid',
            'sun' => 'sun-solid',
            'sync' => 'arrows-rotate-solid',
            'tablet' => 'tablet-solid',
            'tag' => 'tag-solid',
            'tags' => 'tags-solid',
            'thumbs-down' => 'thumbs-down-solid',
            'thumbs-up' => 'thumbs-up-solid',
            'timer' => 'stopwatch-solid',
            'unlock' => 'lock-open-solid',
            'user' => 'user-solid',
            'users' => 'user-group-solid',
            'warning' => 'triangle-exclamation-solid',
            'wrench' => 'wrench-solid',
            'write' => 'pen-to-square-solid',
        ];
    }

    public function name(): string
    {
        return 'Font Awesome Solid';
    }

    public function prefix(): string
    {
        return 'fas';
    }
}
