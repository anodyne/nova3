@aware([
    'admin' => false,
    'form' => null,
    'static' => false,
    'values' => [],
])

@use('Filament\Forms\Components\RichEditor\RichContentRenderer')

{{ RichContentRenderer::make(data_get($details, 'content')) }}
