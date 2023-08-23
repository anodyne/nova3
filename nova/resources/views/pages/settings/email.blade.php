@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Email settings" message="Change the way Nova sends email">
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button.filled color="neutral" leading="search" x-on:click="$dispatch('toggle-spotlight')">
                        Find a setting
                    </x-button.filled>
                </div>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('settings.update', $tab)" method="PUT" id="email">
            <x-form.section title="Basic settings">
                <x-input.group label="Subject prefix">
                    <x-input.text placeholder="[USS Nova]"></x-input.text>
                </x-input.group>

                <x-input.group label="Reply to email address">
                    <x-input.text placeholder="reply-to-nova@example.com"></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Global from address"
                message="You can define the email address and name used for all emails."
            >
                <x-input.group label="From email address">
                    <x-input.text placeholder="nova@example.com"></x-input.text>
                </x-input.group>

                <x-input.group label="From email name">
                    <x-input.text placeholder="USS Nova"></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Logo"
                message="You can upload a logo that will be used in the header of the emails sent from Nova."
            >
                <x-input.group>
                    @livewire('media:upload-image', [
                        'existingImage' => settings()->getFirstMediaUrl('email-logo'),
                        'supportMessage' => 'PNG, JPG, SVG up to 5MB',
                    ])
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" form="email" color="primary">Update</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
