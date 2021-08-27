<x-form :action="route('departments.duplicate', $department)" id="form-duplicate" :divide="false">
    <div class="text-left space-y-8">
        <x-input.group label="Name" for="name">
            <x-input.text name="name" id="name" placeholder="New department name" />
        </x-input.group>
    </div>
</x-form>
