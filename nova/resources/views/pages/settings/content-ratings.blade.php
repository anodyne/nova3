@extends($meta->template)

@section('content')
    <x-spacing x-data="tabsList('language')" constrained>
        <x-page-header>
            <x-slot name="heading">Content ratings</x-slot>

            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" color="neutral">
                        <x-icon name="search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>
        </x-page-header>

        <div>
            <x-spacing size="md" class="sm:hidden">
                <x-select x-on:change="switchTab($event.target.value)" aria-label="Selected tab">
                    <option value="language">Language</option>
                    <option value="sex">Sex</option>
                    <option value="violence">Violence</option>
                </x-select>
            </x-spacing>

            <div class="hidden sm:block">
                <x-tab.group name="ratings" class="mb-6">
                    <x-tab.heading name="language">Language</x-tab.heading>
                    <x-tab.heading name="sex">Sex</x-tab.heading>
                    <x-tab.heading name="violence">Violence</x-tab.heading>
                </x-tab.group>
            </div>
        </div>

        <x-form :action="route('settings.content-ratings.update')" method="PUT" x-show="isTab('language')">
            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="mature"></x-icon>
                    <x-fieldset.legend>Default language rating</x-fieldset.legend>
                    <x-fieldset.description>
                        This is the default language content rating for your game. This is a good way to show current
                        and interested players the type and level of content they can expect from your game.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Rating" id="rating_language" name="rating_language">
                        <livewire:rating area="language" :value="$settings->language->rating" />
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="warning"></x-icon>
                    <x-fieldset.legend>Rating threshold warning</x-fieldset.legend>
                    <x-fieldset.description>
                        You can choose to warn readers about potentially offensive content in a story post if that post
                        meets certain thresholds.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field
                        label="Warn readers when the post rating is at or above"
                        id="language_warning_threshold"
                        name="language[warning_threshold]"
                    >
                        <x-fieldset.warning-message>
                            You have chosen to warn readers about this content, but your threshold is set below the
                            default rating for this category. This means that readers will have to manually agree before
                            being allowed to read every story post unless an author specifically sets the rating lower
                            for their post.
                        </x-fieldset.warning-message>

                        <x-select class="w-full md:w-48">
                            <option value="" @selected($settings->language->warning_threshold === null)>
                                Do not warn
                            </option>
                            <option value="0" @selected($settings->language->warning_threshold === 0)>0</option>
                            <option value="1" @selected($settings->language->warning_threshold === 1)>1</option>
                            <option value="2" @selected($settings->language->warning_threshold === 2)>2</option>
                            <option value="3" @selected($settings->language->warning_threshold === 3)>3</option>
                        </x-select>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Warning message"
                        id="language_warning_threshold_message"
                        name="language[warning_threshold_message]"
                    >
                        <x-input.text :value="$settings->language->warning_threshold_message"></x-input.text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="blockquote"></x-icon>
                    <x-fieldset.legend>Rating level descriptions</x-fieldset.legend>
                    <x-fieldset.description>
                        Customize the descriptions of what is permitted at each level of the rating scale.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Level 0" id="language_description_0" name="language[description_0]">
                        <x-input.textarea rows="1">
                            {{ $settings->language->description_0 }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <x-fieldset.field label="Level 1" id="language_description_1" name="language[description_1]">
                        <x-input.textarea rows="1">
                            {{ $settings->language->description_1 }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <x-fieldset.field label="Level 2" id="language_description_2" name="language[description_2]">
                        <x-input.textarea rows="1">
                            {{ $settings->language->description_2 }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <x-fieldset.field label="Level 3" id="language_description_3" name="language[description_3]">
                        <x-input.textarea rows="1">
                            {{ $settings->language->description_3 }}
                        </x-input.textarea>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>

        <x-form :action="route('settings.content-ratings.update')" method="PUT" x-show="isTab('sex')" x-cloak>
            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="mature"></x-icon>
                    <x-fieldset.legend>Default sex rating</x-fieldset.legend>
                    <x-fieldset.description>
                        This is the default sex content rating for your game. This is a good way to show current and
                        interested players the type and level of content they can expect from your game.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Rating" id="rating_sex" name="rating_sex">
                        <livewire:rating area="sex" :value="$settings->sex->rating" />
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="warning"></x-icon>
                    <x-fieldset.legend>Rating threshold warning</x-fieldset.legend>
                    <x-fieldset.description>
                        You can choose to warn readers about potentially offensive content in a story post if that post
                        meets certain thresholds.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field
                        label="Warn readers when the post rating is at or above"
                        description="You have chosen to warn readers about this content, but your threshold is set below the default rating for this category. This means that readers will have to manually agree before being allowed to read every story post unless an author specifically sets the rating lower for their post."
                        id="sex_warning_threshold"
                        name="sex[warning_threshold]"
                    >
                        <x-select class="w-full md:w-48">
                            <option value="" @selected($settings->sex->warning_threshold === null)>Do not warn</option>
                            <option value="0" @selected($settings->sex->warning_threshold === 0)>0</option>
                            <option value="1" @selected($settings->sex->warning_threshold === 1)>1</option>
                            <option value="2" @selected($settings->sex->warning_threshold === 2)>2</option>
                            <option value="3" @selected($settings->sex->warning_threshold === 3)>3</option>
                        </x-select>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Warning message"
                        id="sex_warning_threshold_message"
                        name="sex[warning_threshold_message]"
                    >
                        <x-input.text :value="$settings->sex->warning_threshold_message"></x-input.text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="blockquote"></x-icon>
                    <x-fieldset.legend>Rating level descriptions</x-fieldset.legend>
                    <x-fieldset.description>
                        Customize the descriptions of what is permitted at each level of the rating scale.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Level 0" id="sex_description_0" name="sex[description_0]">
                        <x-input.textarea rows="1">
                            {{ $settings->sex->description_0 }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <x-fieldset.field label="Level 1" id="sex_description_1" name="sex[description_1]">
                        <x-input.textarea rows="1">
                            {{ $settings->sex->description_1 }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <x-fieldset.field label="Level 2" id="sex_description_2" name="sex[description_2]">
                        <x-input.textarea rows="1">
                            {{ $settings->sex->description_2 }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <x-fieldset.field label="Level 3" id="sex_description_3" name="sex[description_3]">
                        <x-input.textarea rows="1">
                            {{ $settings->sex->description_3 }}
                        </x-input.textarea>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>

        <x-form :action="route('settings.content-ratings.update')" method="PUT" x-show="isTab('violence')" x-cloak>
            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="mature"></x-icon>
                    <x-fieldset.legend>Default violence rating</x-fieldset.legend>
                    <x-fieldset.description>
                        This is the default violence content rating for your game. This is a good way to show current
                        and interested players the type and level of content they can expect from your game.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Rating" id="rating_violence" name="rating_violence">
                        <livewire:rating area="violence" :value="$settings->violence->rating" />
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="warning"></x-icon>
                    <x-fieldset.legend>Rating threshold warning</x-fieldset.legend>
                    <x-fieldset.description>
                        You can choose to warn readers about potentially offensive content in a story post if that post
                        meets certain thresholds.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field
                        label="Warn readers when the post rating is at or above"
                        description="You have chosen to warn readers about this content, but your threshold is set below the default rating for this category. This means that readers will have to manually agree before being allowed to read every story post unless an author specifically sets the rating lower for their post."
                        id="violence_warning_threshold"
                        name="violence[warning_threshold]"
                    >
                        <x-select class="w-full md:w-48">
                            <option value="" @selected($settings->violence->warning_threshold === null)>
                                Do not warn
                            </option>
                            <option value="0" @selected($settings->violence->warning_threshold === 0)>0</option>
                            <option value="1" @selected($settings->violence->warning_threshold === 1)>1</option>
                            <option value="2" @selected($settings->violence->warning_threshold === 2)>2</option>
                            <option value="3" @selected($settings->violence->warning_threshold === 3)>3</option>
                        </x-select>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Warning message"
                        id="violence_warning_threshold_message"
                        name="violence[warning_threshold_message]"
                    >
                        <x-input.text :value="$settings->violence->warning_threshold_message"></x-input.text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="blockquote"></x-icon>
                    <x-fieldset.legend>Rating level descriptions</x-fieldset.legend>
                    <x-fieldset.description>
                        Customize the descriptions of what is permitted at each level of the rating scale.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Level 0" id="violence_description_0" name="violence[description_0]">
                        <x-input.textarea rows="1">
                            {{ $settings->violence->description_0 }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <x-fieldset.field label="Level 1" id="violence_description_1" name="violence[description_1]">
                        <x-input.textarea rows="1">
                            {{ $settings->violence->description_1 }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <x-fieldset.field label="Level 2" id="violence_description_2" name="violence[description_2]">
                        <x-input.textarea rows="1">
                            {{ $settings->violence->description_2 }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <x-fieldset.field label="Level 3" id="violence_description_3" name="violence[description_3]">
                        <x-input.textarea rows="1">
                            {{ $settings->violence->description_3 }}
                        </x-input.textarea>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
