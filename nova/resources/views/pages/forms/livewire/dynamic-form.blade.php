@use('Nova\Forms\Enums\FormMode')

<div class="space-y-12">
    <x-form.dynamic :$admin :$form :$static :$values>
        {!! scribble($fields ?? ['content' => null])->toHtml() !!}
    </x-form.dynamic>

    @if ($showsFormControls)
        <div>
            @if ($mode === FormMode::Create)
                @if ($admin)
                    <x-button type="button" color="primary" wire:click="submit">Submit</x-button>
                @else
                    <div class="flex items-center gap-x-4">
                        <x-public::button type="button" wire:click="submit" bg-color="#cccccc" primary>
                            Submit
                        </x-public::button>

                        {{-- <div class="flex items-center">Submitted</div> --}}
                    </div>
                @endif
            @endif

            @if ($mode === FormMode::Edit)
                <x-button type="button" color="primary" wire:click="update">Update</x-button>
            @endif
        </div>
    @endif
</div>
