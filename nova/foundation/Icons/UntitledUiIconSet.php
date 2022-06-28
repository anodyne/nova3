<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class UntitledUiIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'plus-circle',
            'alert' => 'alert-circle',
            'arrow-down' => 'arrow-circle-broken-down',
            'arrow-left' => 'arrow-circle-broken-left',
            'arrow-right' => 'arrow-circle-broken-right',
            'arrow-up' => 'arrow-circle-broken-up',
            'arrow-sort' => 'switch-vertical-01',
            'book' => 'book-closed',
            'bookmark' => 'bookmark',
            'calendar' => 'calendar',
            'chart' => 'line-chart-up-01',
            'chat' => 'message-chat-circle',
            'check' => 'check-circle-broken',
            'clock' => 'clock',
            'close' => 'x-close',
            'cloud' => 'cloud-01',
            'copy' => 'copy-07',
            'dashboard' => 'speedometer-02',
            'database' => 'database-01',
            'delete' => 'trash-03',
            'desktop' => 'monitor-01',
            'drop' => 'droplets-03',
            'edit' => 'edit-02',
            'email' => 'mail-01',
            'emoji' => 'face-smile',
            'filter' => 'filter-funnel-01',
            'flag' => 'flag-02',
            'flash' => 'flash',
            'folder' => 'folder',
            'form' => 'text-input',
            'globe' => 'globe-01',
            'heart' => 'heart',
            'hide' => 'eye-off',
            'history' => 'clock-rewind',
            'home' => 'home-03',
            'image' => 'image-03',
            'info' => 'info-circle',
            'layer' => 'layers-three-01',
            'lightbulb' => 'lightbulb-05',
            'link' => 'link-03',
            'list' => 'list',
            'location' => 'marker-pin-01',
            'lock' => 'lock-04',
            'mature' => 'shield-01',
            'menu' => 'menu-03',
            'moon' => 'moon-01',
            'move-down' => 'corner-right-down',
            'move-right' => 'corner-down-right',
            'move-up' => 'corner-right-up',
            'note' => 'file-02',
            'notification' => 'bell-01',
            'paint-bucket' => 'paint-pour',
            'phone' => 'phone-01',
            'prohibited' => 'slash-circle-01',
            'question' => 'help-circle',
            'remove' => 'minus-circle',
            'rocket' => 'rocket-02',
            'search' => 'search-sm',
            'send' => 'send-01',
            'server' => 'server-04',
            'settings' => 'settings-01',
            'share' => 'share-05',
            'shield' => 'shield-01',
            'show' => 'eye',
            'sign-in' => 'log-in-03',
            'sign-out' => 'log-out-03',
            'star' => 'star-01',
            'sun' => 'sun',
            'sync' => 'repeat-04',
            'tablet' => 'tablet-01',
            'tag' => 'tag-01',
            'tags' => 'tag-03',
            'thumbs-down' => 'thumbs-down',
            'thumbs-up' => 'thumbs-up',
            'timer' => 'clock-stopwatch',
            'unlock' => 'lock-unlocked-04',
            'user' => 'user-01',
            'users' => 'users-01',
            'warning' => 'alert-triangle',
            'wrench' => 'tool-02',
            'write' => 'edit-05',
        ];
    }

    public function name(): string
    {
        return 'Untitled UI';
    }

    public function prefix(): string
    {
        return 'untitled';
    }
}
