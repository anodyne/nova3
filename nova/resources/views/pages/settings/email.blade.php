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
                    <x-input.text :value="config('mail.from.address')"></x-input.text>
                </x-input.group>

                <x-input.group label="From email name">
                    <x-input.text :value="config('mail.from.name')"></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Logo"
                message="You can upload a logo that will be used in the header of the emails sent from Nova."
            >
                <x-input.group>
                    @livewire('media:upload-image', [
                        'existingImage' => settings()->getFirstMediaUrl('email-logo'),
                        'supportMessage' => 'PNG or JPG up to 5MB',
                    ])
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Configuration"
                message="You can set your email configuration values and they'll be written to the configuration file for you."
            >
                <x-input.group label="Host">
                    <x-input.text :value="config('mail.mailers.smtp.host')"></x-input.text>
                </x-input.group>

                <x-input.group label="Port">
                    <x-input.text :value="config('mail.mailers.smtp.port')"></x-input.text>
                </x-input.group>

                <x-input.group label="Username">
                    <x-input.text :value="config('mail.mailers.smtp.username')"></x-input.text>
                </x-input.group>

                <x-input.group label="Password">
                    <x-input.text :value="config('mail.mailers.smtp.password')"></x-input.text>
                </x-input.group>

                <x-input.group label="Encryption">
                    <x-input.text :value="config('mail.mailers.smtp.encryption')"></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" form="email" color="primary">Update</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
