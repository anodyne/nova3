@use('Nova\Departments\Models\Position')
@use('Nova\Foundation\Enums\BasicStatus')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            @can('viewAny', Position::class)
                <x-slot name="actions">
                    <x-button
                        :href="route('admin.positions.index', 'department='.$position->department->id)"
                        variant="ghost"
                        inset="right"
                    >
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

        <x-form :action="route('admin.positions.update', $position)" method="PUT">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-input label="Name" name="name" :value="old('name', $position->name)" />

                    <x-select label="Department" name="department_id">
                        @foreach ($departments as $department)
                            <option
                                value="{{ $department->id }}"
                                @selected($department->id == old('department_id', $position->department_id))
                            >
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-textarea label="Description" name="description" rows="5">
                        {{ old('description', $position->description) }}
                    </x-textarea>

                    <x-switch
                        label="Active"
                        name="status"
                        :checked="old('status', $position->status === BasicStatus::Active)"
                        align="left"
                    />

                    <x-textarea
                        label="Tags"
                        description="A comma-separated list of tags that can be used for organizing your manifest(s)"
                        name="tags"
                        rows="2"
                    >
                        {{ old('tags', $position->tags_as_string) }}
                    </x-textarea>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::DoorEnter" heading="Availability">
                    <x-description>
                        You can allow or prevent players from picking this position by setting the number of available
                        slots.
                    </x-description>

                    @can('update', settings())
                        <x-description>
                            Nova can keep the number of available slots for a position updated for you as characters are
                            assigned and un-assigned to the position. You can update the availability settings for
                            individual character types from Character Settings.
                        </x-description>

                        <x-button :href="route('admin.settings.characters.edit')">
                            Go to character settings
                            <span aria-hidden="true">→</span>
                        </x-button>
                    @endcan
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <div class="w-full sm:w-1/2">
                        <x-input.number
                            label="Available Slots"
                            name="available"
                            :value="old('available', $position->available)"
                        />
                    </div>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
                <x-button :href="route('admin.positions.index', $position->department)" variant="ghost">
                    Cancel
                </x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
