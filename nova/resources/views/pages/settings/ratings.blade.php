@extends($meta->template)

@section('content')
    <x-panel x-data="tabsList('language')">
        <x-panel.header title="Content ratings settings">
            <x-slot:controls>
                <div x-data="{}">
                    <x-button color="primary-outline" @click="$dispatch('toggle-spotlight')" leading="search">
                        Find a setting
                    </x-button>
                </div>
            </x-slot:controls>
        </x-panel.header>

        <div>
            <x-content-box class="sm:hidden">
                <x-input.select @change="switchTab($event.target.value)" aria-label="Selected tab">
                    <option value="language">Language</option>
                    <option value="sex">Sex</option>
                    <option value="violence">Violence</option>
                </x-input.select>
            </x-content-box>
            <div class="hidden sm:block">
                <x-content-box height="none" class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-200/10">
                    {{-- <nav class="flex space-x-2 px-1 py-1 rounded-lg bg-gray-100 dark:bg-gray-700/50 border-gray-200 dark:border-gray-200/10">
                        <a href="#" class="flex items-center rounded-md px-4 py-1.5 font-medium text-sm transition" :class="{ 'bg-white dark:bg-gray-600 shadow dark:highlight-white/5 ring-1 ring-gray-900/5 text-gray-900 dark:text-gray-100': isTab('language'), 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('language') }" @click.prevent="switchTab('language')">
                            Language
                        </a>
                        <a href="#" class="flex items-center rounded-md px-4 py-1.5 font-medium text-sm transition" :class="{ 'bg-white dark:bg-gray-600 shadow dark:highlight-white/5 ring-1 ring-gray-900/5 text-gray-900 dark:text-gray-100': isTab('sex'), 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('sex') }" @click.prevent="switchTab('sex')">
                            Sex
                        </a>
                        <a href="#" class="flex items-center rounded-md px-4 py-1.5 font-medium text-sm transition" :class="{ 'bg-white dark:bg-gray-600 shadow dark:highlight-white/5 ring-1 ring-gray-900/5 text-gray-900 dark:text-gray-100': isTab('violence'), 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('violence') }" @click.prevent="switchTab('violence')">
                            Violence
                        </a>
                    </nav> --}}
                    <nav class="-mb-px flex">
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('language'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('language') }" @click.prevent="switchTab('language')">
                            Language
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('sex'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('sex') }" @click.prevent="switchTab('sex')">
                            Sex
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('violence'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('violence') }" @click.prevent="switchTab('violence')">
                            Violence
                        </a>
                    </nav>
                </x-content-box>
            </div>
        </div>

        <x-form :action="route('settings.update', $tab)" method="PUT" id="language" x-show="isTab('language')">
            <x-form.section title="Default rating" message="This is the default content rating for language for your game. This is a good way to show current and interested players the type and level of content they can expect from your game.">
                <x-input.group label="Rating" class="w-full md:w-72">
                    <livewire:rating type="language" :rating="$settings->ratings->language->rating" />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Rating threshold warning" message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds.">
                <x-input.group label="Warn readers when rating is at or above" help="You have chosen to warn readers about this content, but your threshold is set below the default rating for this category. This means that readers will have to manually agree before being allowed to read every story post unless an author specifically sets the rating lower for their post.">
                    <x-input.select name="language[warning_threshold]" class="w-full md:w-48">
                        <option value="" @selected($settings->ratings->language->warning_threshold === null)>Do not warn</option>
                        <option value="0" @selected($settings->ratings->language->warning_threshold === 0)>0</option>
                        <option value="1" @selected($settings->ratings->language->warning_threshold === 1)>1</option>
                        <option value="2" @selected($settings->ratings->language->warning_threshold === 2)>2</option>
                        <option value="3" @selected($settings->ratings->language->warning_threshold === 3)>3</option>
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Warning message">
                    <x-input.text name="language[warning_threshold_message]" :value="$settings->ratings->language->warning_threshold_message"></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Rating level descriptions" message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds with any one of the content categories.">
                <x-input.group label="Description (Level 0)">
                    <x-input.textarea rows="1" name="language[description_0]">{{ $settings->ratings->language->description_0 }}</x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 1)">
                    <x-input.textarea rows="1" name="language[description_1]">{{ $settings->ratings->language->description_1 }}</x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 2)">
                    <x-input.textarea rows="1" name="language[description_2]">{{ $settings->ratings->language->description_2 }}</x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 3)">
                    <x-input.textarea rows="1" name="language[description_3]">{{ $settings->ratings->language->description_3 }}</x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" form="language" color="primary">Update</x-button>
            </x-form.footer>
        </x-form>

        <x-form :action="route('settings.update', $tab)" method="PUT" id="sex" x-show="isTab('sex')" x-cloak>
            <x-form.section title="Default rating" message="This is the default content rating for sex for your game. This is a good way to show current and interested players the type and level of content they can expect from your game.">
                <x-input.group label="Rating" class="w-full md:w-72">
                    <livewire:rating type="sex" :rating="$settings->ratings->sex->rating" />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Rating threshold warning" message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds.">
                <x-input.group label="Warn readers when rating is at or above" help="You have chosen to warn readers about this content, but your threshold is set below the default rating for this category. This means that readers will have to manually agree before being allowed to read every story post unless an author specifically sets the rating lower for their post.">
                    <x-input.select name="sex[warning_threshold]" class="w-full md:w-48">
                        <option value="" @selected($settings->ratings->sex->warning_threshold === null)>Do not warn</option>
                        <option value="0" @selected($settings->ratings->sex->warning_threshold === 0)>0</option>
                        <option value="1" @selected($settings->ratings->sex->warning_threshold === 1)>1</option>
                        <option value="2" @selected($settings->ratings->sex->warning_threshold === 2)>2</option>
                        <option value="3" @selected($settings->ratings->sex->warning_threshold === 3)>3</option>
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Warning message">
                    <x-input.text name="sex[warning_threshold_message]" :value="$settings->ratings->sex->warning_threshold_message"></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Rating level descriptions" message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds with any one of the content categories.">
                <x-input.group label="Description (Level 0)">
                    <x-input.textarea rows="1" name="sex[description_0]">{{ $settings->ratings->sex->description_0 }}</x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 1)">
                    <x-input.textarea rows="1" name="sex[description_1]">{{ $settings->ratings->sex->description_1 }}</x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 2)">
                    <x-input.textarea rows="1" name="sex[description_2]">{{ $settings->ratings->sex->description_2 }}</x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 3)">
                    <x-input.textarea rows="1" name="sex[description_3]">{{ $settings->ratings->sex->description_3 }}</x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" form="sex" color="primary">Update</x-button>
            </x-form.footer>
        </x-form>

        <x-form :action="route('settings.update', $tab)" method="PUT" id="violence" x-show="isTab('violence')" x-cloak>
            <x-form.section title="Default rating" message="This is the default content rating for violence for your game. This is a good way to show current and interested players the type and level of content they can expect from your game.">
                <x-input.group label="Rating" class="w-full md:w-72">
                    <livewire:rating type="violence" :rating="$settings->ratings->violence->rating" />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Rating threshold warning" message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds.">
                <x-input.group label="Warn readers when rating is at or above" help="You have chosen to warn readers about this content, but your threshold is set below the default rating for this category. This means that readers will have to manually agree before being allowed to read every story post unless an author specifically sets the rating lower for their post.">
                    <x-input.select name="violence[warning_threshold]" class="w-full md:w-48">
                        <option value="" @selected($settings->ratings->violence->warning_threshold === null)>Do not warn</option>
                        <option value="0" @selected($settings->ratings->violence->warning_threshold === 0)>0</option>
                        <option value="1" @selected($settings->ratings->violence->warning_threshold === 1)>1</option>
                        <option value="2" @selected($settings->ratings->violence->warning_threshold === 2)>2</option>
                        <option value="3" @selected($settings->ratings->violence->warning_threshold === 3)>3</option>
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Warning message">
                    <x-input.text name="violence[warning_threshold_message]" :value="$settings->ratings->violence->warning_threshold_message"></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Rating level descriptions" message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds with any one of the content categories.">
                <x-input.group label="Description (Level 0)">
                    <x-input.textarea rows="1" name="violence[description_0]">{{ $settings->ratings->violence->description_0 }}</x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 1)">
                    <x-input.textarea rows="1" name="violence[description_1]">{{ $settings->ratings->violence->description_1 }}</x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 2)">
                    <x-input.textarea rows="1" name="violence[description_2]">{{ $settings->ratings->violence->description_2 }}</x-input.textarea>
                </x-input.group>

                <x-input.group label="Description (Level 3)">
                    <x-input.textarea rows="1" name="violence[description_3]">{{ $settings->ratings->violence->description_3 }}</x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" form="violence" color="primary">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
