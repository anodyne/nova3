<?php

declare(strict_types=1);

use Nova\Applications\Livewire\ApplicationDecisionModal;
use Nova\Dashboards\Livewire\NovaUpdatePanel;
use Nova\Discussions\Livewire\ComposeMessage;
use Nova\Foundation\Livewire\Modal;
use Nova\Media\Livewire\AvatarEditor;
use Nova\Search\Livewire\GlobalSearch;
use Nova\Stories\Livewire\PostAuthorsEditor;
use Nova\Stories\Livewire\PostRatingsEditor;

uses()->group('foundation', 'modals');

describe('ModalAttributes', function () {
    it('falls back to a large modal when a component does not declare a size', function () {
        expect(AvatarEditor::size())->toBe('lg')
            ->and(AvatarEditor::sizeClass())->toBe('max-w-lg');

        expect(ApplicationDecisionModal::sizeClass())->toBe('max-w-lg');
    });

    it('maps a declared size onto its max-width utility', function (string $component, string $size, string $class) {
        expect($component::size())->toBe($size)
            ->and($component::sizeClass())->toBe($class);
    })->with([
        'ratings editor (lg)' => [PostRatingsEditor::class, 'lg', 'max-w-lg'],
        'update panel (xl)' => [NovaUpdatePanel::class, 'xl', 'max-w-xl'],
        'compose message (2xl)' => [ComposeMessage::class, '2xl', 'max-w-2xl'],
        'global search (2xl)' => [GlobalSearch::class, '2xl', 'max-w-2xl'],
        'authors editor (3xl)' => [PostAuthorsEditor::class, '3xl', 'max-w-3xl'],
    ]);

    it('exposes the size to the view through modalSize', function () {
        expect((new AvatarEditor)->modalSize())->toBe('lg')
            ->and((new PostAuthorsEditor)->modalSize())->toBe('3xl');
    });

    it('covers every size the modal chrome accepts', function (string $size, string $class) {
        $component = new class extends Modal
        {
            public static string $declaredSize = 'lg';

            public static function size(): string
            {
                return self::$declaredSize;
            }
        };

        $component::$declaredSize = $size;

        expect($component::sizeClass())->toBe($class);
    })->with([
        ['xs', 'max-w-xs'],
        ['sm', 'max-w-sm'],
        ['md', 'max-w-md'],
        ['lg', 'max-w-lg'],
        ['xl', 'max-w-xl'],
        ['2xl', 'max-w-2xl'],
        ['3xl', 'max-w-3xl'],
        ['4xl', 'max-w-4xl'],
        ['5xl', 'max-w-5xl'],
        ['6xl', 'max-w-6xl'],
        ['7xl', 'max-w-7xl'],
        ['fullscreen', 'max-w-full'],
    ]);

    it('falls back to the default utility for an unknown size', function () {
        $component = new class extends Modal
        {
            public static function size(): string
            {
                return 'gigantic';
            }
        };

        expect($component::sizeClass())->toBe('max-w-lg');
    });
});
