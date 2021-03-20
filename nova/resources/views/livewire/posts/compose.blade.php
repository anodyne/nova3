<x-panel>
    <x-form action="">
        <x-form.section title="Story" message="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur autem sapiente, eum exercitationem ullam debitis doloremque necessitatibus tempora quasi possimus quaerat asperiores repellat ab nulla pariatur non nisi voluptatibus. Commodi!">
            <div class="w-full">
                <x-input.select>
                    @foreach ($allStories as $selectStory)
                        <option value="{{ $selectStory->id }}">{{ $selectStory->title }}</option>
                    @endforeach
                </x-input.select>
            </div>
        </x-form.section>

        <x-form.section title="Post Info" message="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur autem sapiente, eum exercitationem ullam debitis doloremque necessitatibus tempora quasi possimus quaerat asperiores repellat ab nulla pariatur non nisi voluptatibus. Commodi!">
            <x-posts.field
                :field="$postType->fields->title"
                name="title"
                :suggestion="$suggestion"
                :value="$title"
                wire:model.lazy="title"
                placeholder="Add your title"
                tabindex="1"
                class="w-2/3"
            ></x-posts.field>

            <x-posts.field
                :field="$postType->fields->day"
                icon="calendar"
                name="day"
                :suggestion="$suggestion"
                :value="$day"
                wire:model.lazy="day"
                placeholder="Add a day"
                tabindex="2"
                class="w-2/3"
            ></x-posts.field>

            <x-posts.field
                :field="$postType->fields->time"
                icon="clock"
                name="time"
                :suggestion="$suggestion"
                :value="$time"
                wire:model.lazy="time"
                placeholder="Add a time"
                tabindex="3"
                class="w-2/3"
            ></x-posts.field>

            <x-posts.field
                :field="$postType->fields->location"
                icon="location"
                name="location"
                :suggestion="$suggestion"
                :value="$location"
                wire:model.lazy="location"
                placeholder="Add a location"
                tabindex="4"
                class="w-2/3"
            ></x-posts.field>
        </x-form.section>

        <x-form.section title="Author(s)" message="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur autem sapiente, eum exercitationem ullam debitis doloremque necessitatibus tempora quasi possimus quaerat asperiores repellat ab nulla pariatur non nisi voluptatibus. Commodi!">
            <x-input.group label="Your character(s)">
                Select your character(s)
            </x-input.group>

            @if ($postType->options->multipleAuthors)
                <x-input.group label="Other characters">
                    Add more characters
                </x-input.group>

                <x-input.group label="Other contributors">
                    Add other contributors
                </x-input.group>
            @endif
        </x-form.section>

        <x-form.section>
            <x-editor.post wire:model="content" />
        </x-form.section>

        <x-form.section title="Ratings">
            <x-slot name="message">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia quam eius provident ex modi nam, at ullam quia labore similique.</p>

                <p><strong>Note:</strong> Your post's ratings will match the game's overall ratings until you change them for this post.</p>
            </x-slot>

            <x-input.group label="Language" class="w-72">
                {{-- <x-input.number min="1" max="3" value="1" name="ratings[language]" /> --}}
                <div class="flex items-center rounded-full space-x-1 overflow-hidden text-sm font-semibold">
                    <div class="flex-1 py-0.5 bg-green-500 text-white text-center">0</div>
                    <a href="#" class="flex-1 py-0.5 bg-gray-300 hover:bg-gray-400 text-white text-center transition ease-in-out duration-150">&nbsp;</a>
                    <a href="#" class="flex-1 py-0.5 bg-gray-300 hover:bg-gray-400 text-white text-center transition ease-in-out duration-150">&nbsp;</a>
                    <a href="#" class="flex-1 py-0.5 bg-gray-300 hover:bg-gray-400 text-white text-center transition ease-in-out duration-150">&nbsp;</a>
                </div>
            </x-input.group>

            <x-input.group label="Sex" class="w-72">
                {{-- <x-input.number min="1" max="3" value="1" name="ratings[sex]" /> --}}
                <div class="flex items-center rounded-full space-x-1 overflow-hidden text-sm font-semibold">
                    <div class="flex-1 py-0.5 bg-yellow-500 text-white text-center">&nbsp;</div>
                    <a href="#" class="flex-1 py-0.5 bg-yellow-500 hover:bg-gray-400 text-white text-center transition ease-in-out duration-150">1</a>
                    <a href="#" class="flex-1 py-0.5 bg-gray-300 hover:bg-gray-400 text-white text-center transition ease-in-out duration-150">&nbsp;</a>
                    <a href="#" class="flex-1 py-0.5 bg-gray-300 hover:bg-gray-400 text-white text-center transition ease-in-out duration-150">&nbsp;</a>
                </div>
            </x-input.group>

            <x-input.group label="Violence" class="w-72">
                {{-- <x-input.number min="1" max="3" value="1" name="ratings[violence]" /> --}}
                <div class="flex items-center rounded-full space-x-1 overflow-hidden text-sm font-semibold">
                    <div class="flex-1 py-0.5 bg-orange-500 text-white text-center">&nbsp;</div>
                    <a href="#" class="flex-1 py-0.5 bg-orange-500 hover:bg-gray-400 text-white text-center transition ease-in-out duration-150">&nbsp;</a>
                    <a href="#" class="flex-1 py-0.5 bg-orange-500 hover:bg-gray-400 text-white text-center transition ease-in-out duration-150">2</a>
                    <a href="#" class="flex-1 py-0.5 bg-gray-300 hover:bg-gray-400 text-white text-center transition ease-in-out duration-150">&nbsp;</a>
                </div>
            </x-input.group>
        </x-form.section>

        <x-form.footer>
            <x-button wire:click="publish" color="blue">Publish</x-button>

            <x-button wire:click="save" wire:poll.30s="save" color="white">
                Save
            </x-button>

            <div class="text-gray-600" wire:loading.delay>Saving...</div>
        </x-form.footer>
    </x-form>
</x-panel>