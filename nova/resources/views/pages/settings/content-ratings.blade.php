@extends($meta->template)

@section('content')
    <x-panel x-data="tabsList('language')">
        <x-panel.header
            title="Content ratings"
            message="Let players and readers know what to expect from your game's content with content ratings and warnings"
        >
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" plain>
                        <x-icon name="search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>

            <div>
                <x-content-box class="sm:hidden">
                    <x-input.select @change="switchTab($event.target.value)" aria-label="Selected tab">
                        <option value="language">Language</option>
                        <option value="sex">Sex</option>
                        <option value="violence">Violence</option>
                    </x-input.select>
                </x-content-box>
                <div class="hidden sm:block">
                    <x-content-box height="none">
                        <nav class="-mb-px flex">
                            <a
                                href="#"
                                class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                                :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('language'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('language') }"
                                x-on:click.prevent="switchTab('language')"
                            >
                                Language
                            </a>
                            <a
                                href="#"
                                class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                                :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('sex'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('sex') }"
                                x-on:click.prevent="switchTab('sex')"
                            >
                                Sex
                            </a>
                            <a
                                href="#"
                                class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                                :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('violence'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('violence') }"
                                x-on:click.prevent="switchTab('violence')"
                            >
                                Violence
                            </a>
                        </nav>
                    </x-content-box>
                </div>
            </div>
        </x-panel.header>

        <x-form :action="route('settings.content-ratings.update')" method="PUT" x-show="isTab('language')">
            <x-form.section
                title="Default language rating"
                message="This is the default language content rating for your game. This is a good way to show current and interested players the type and level of content they can expect from your game."
            >
                <x-input.group label="Rating" class="w-full md:w-72">
                    <livewire:rating area="language" :value="$settings->language->rating" />
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Rating threshold warning"
                message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds."
            >
                <x-input.group
                    label="Warn readers when the post rating is at or above"
                    help="You have chosen to warn readers about this content, but your threshold is set below the default rating for this category. This means that readers will have to manually agree before being allowed to read every story post unless an author specifically sets the rating lower for their post."
                >
                    <x-input.select name="language[warning_threshold]" class="w-full md:w-48">
                        <option value="" @selected($settings->language->warning_threshold === null)>
                            Do not warn
                        </option>
                        <option value="0" @selected($settings->language->warning_threshold === 0)>0</option>
                        <option value="1" @selected($settings->language->warning_threshold === 1)>1</option>
                        <option value="2" @selected($settings->language->warning_threshold === 2)>2</option>
                        <option value="3" @selected($settings->language->warning_threshold === 3)>3</option>
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Warning message">
                    <x-input.text
                        name="language[warning_threshold_message]"
                        :value="$settings->language->warning_threshold_message"
                    ></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Rating level descriptions"
                message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds with any one of the content categories."
            >
                <x-input.group label="Description (Level 0)">
                    <x-input.textarea rows="1" name="language[description_0]">
                        {{ $settings->language->description_0 }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 1)">
                    <x-input.textarea rows="1" name="language[description_1]">
                        {{ $settings->language->description_1 }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 2)">
                    <x-input.textarea rows="1" name="language[description_2]">
                        {{ $settings->language->description_2 }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 3)">
                    <x-input.textarea rows="1" name="language[description_3]">
                        {{ $settings->language->description_3 }}
                    </x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Update</x-button>
            </x-form.footer>
        </x-form>

        <x-form :action="route('settings.content-ratings.update')" method="PUT" x-show="isTab('sex')" x-cloak>
            <x-form.section
                title="Default sex rating"
                message="This is the default sex content rating for your game. This is a good way to show current and interested players the type and level of content they can expect from your game."
            >
                <x-input.group label="Rating" class="w-full md:w-72">
                    <livewire:rating area="sex" :value="$settings->sex->rating" />
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Rating threshold warning"
                message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds."
            >
                <x-input.group
                    label="Warn readers when the post rating is at or above"
                    help="You have chosen to warn readers about this content, but your threshold is set below the default rating for this category. This means that readers will have to manually agree before being allowed to read every story post unless an author specifically sets the rating lower for their post."
                >
                    <x-input.select name="sex[warning_threshold]" class="w-full md:w-48">
                        <option value="" @selected($settings->sex->warning_threshold === null)>Do not warn</option>
                        <option value="0" @selected($settings->sex->warning_threshold === 0)>0</option>
                        <option value="1" @selected($settings->sex->warning_threshold === 1)>1</option>
                        <option value="2" @selected($settings->sex->warning_threshold === 2)>2</option>
                        <option value="3" @selected($settings->sex->warning_threshold === 3)>3</option>
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Warning message">
                    <x-input.text
                        name="sex[warning_threshold_message]"
                        :value="$settings->sex->warning_threshold_message"
                    ></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Rating level descriptions"
                message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds with any one of the content categories."
            >
                <x-input.group label="Description (Level 0)">
                    <x-input.textarea rows="1" name="sex[description_0]">
                        {{ $settings->sex->description_0 }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 1)">
                    <x-input.textarea rows="1" name="sex[description_1]">
                        {{ $settings->sex->description_1 }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 2)">
                    <x-input.textarea rows="1" name="sex[description_2]">
                        {{ $settings->sex->description_2 }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 3)">
                    <x-input.textarea rows="1" name="sex[description_3]">
                        {{ $settings->sex->description_3 }}
                    </x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Update</x-button>
            </x-form.footer>
        </x-form>

        <x-form :action="route('settings.content-ratings.update')" method="PUT" x-show="isTab('violence')" x-cloak>
            <x-form.section
                title="Default violence rating"
                message="This is the default sex content rating for your game. This is a good way to show current and interested players the type and level of content they can expect from your game."
            >
                <x-input.group label="Rating" class="w-full md:w-72">
                    <livewire:rating area="violence" :value="$settings->violence->rating" />
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Rating threshold warning"
                message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds."
            >
                <x-input.group
                    label="Warn readers when the post rating is at or above"
                    help="You have chosen to warn readers about this content, but your threshold is set below the default rating for this category. This means that readers will have to manually agree before being allowed to read every story post unless an author specifically sets the rating lower for their post."
                >
                    <x-input.select name="violence[warning_threshold]" class="w-full md:w-48">
                        <option value="" @selected($settings->violence->warning_threshold === null)>
                            Do not warn
                        </option>
                        <option value="0" @selected($settings->violence->warning_threshold === 0)>0</option>
                        <option value="1" @selected($settings->violence->warning_threshold === 1)>1</option>
                        <option value="2" @selected($settings->violence->warning_threshold === 2)>2</option>
                        <option value="3" @selected($settings->violence->warning_threshold === 3)>3</option>
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Warning message">
                    <x-input.text
                        name="violence[warning_threshold_message]"
                        :value="$settings->violence->warning_threshold_message"
                    ></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Rating level descriptions"
                message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds with any one of the content categories."
            >
                <x-input.group label="Description (Level 0)">
                    <x-input.textarea rows="1" name="violence[description_0]">
                        {{ $settings->violence->description_0 }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 1)">
                    <x-input.textarea rows="1" name="violence[description_1]">
                        {{ $settings->violence->description_1 }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 2)">
                    <x-input.textarea rows="1" name="violence[description_2]">
                        {{ $settings->violence->description_2 }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 3)">
                    <x-input.textarea rows="1" name="violence[description_3]">
                        {{ $settings->violence->description_3 }}
                    </x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
