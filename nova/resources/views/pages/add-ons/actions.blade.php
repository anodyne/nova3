@php
    $addonClass = $record->getAddonClass();
@endphp

<x-filament.modal-content icon="automation" title="Add-on actions">
    @includeWhen($addonClass->isRankSet(), 'pages.add-ons.actions-rank-set', [
        'action' => $action,
        'addonClass' => $addonClass,
        'record' => $record,
    ])

    @includeWhen($addonClass->isGenre(), 'pages.add-ons.actions-genre', [
        'action' => $action,
        'addonClass' => $addonClass,
        'record' => $record,
    ])

    @includeWhen($addonClass->isExtension(), 'pages.add-ons.actions-extension', [
        'action' => $action,
        'addonClass' => $addonClass,
        'record' => $record,
    ])
</x-filament.modal-content>
