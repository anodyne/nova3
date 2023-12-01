@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="General settings">
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button.filled color="neutral" leading="search" x-on:click="$dispatch('toggle-spotlight')">
                        Find a setting
                    </x-button.filled>
                </div>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('settings.update')" method="PUT" id="general">
            <x-form.section title="Game info">
                <x-input.group label="Game name">
                    <x-input.text
                        name="game_name"
                        :value="$settings->general->gameName"
                        placeholder="Set your game's name"
                    ></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Date format"
                message="You can set what format you would like dates displayed in throughout Nova."
            >
                <x-slot name="message">
                    <p>You can set the format you'd like dates displayed throughout Nova.</p>
                    <p>
                        <strong class="font-semibold">Example:</strong>
                        {{ format_date(now()) }}
                    </p>
                </x-slot>

                <x-input.group
                    label="Date format"
                    help="To see a list of available date and time format tokens, type # followed by the token you'd like to find (e.g. month or day). You can also insert other characters into the string (such as at symbols or colons) and it will be formatted with those values."
                >
                    <x-input.date-format
                        :value="$settings->general->dateFormatTags"
                        placeholder="Set date format"
                    ></x-input.date-format>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" form="general" color="primary">Update</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
