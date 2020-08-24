<x-form :action="route('ranks.groups.duplicate', $group)" id="form-duplicate">
    <div class="text-left">
        <x-input.group label="Name" for="name">
            <x-input.text name="name" id="name" placeholder="New rank group name" />
        </x-input.group>

        <x-input.group label="New Base Image" for="base_image">
            <x-input.select name="base_image" id="base_image" class="w-full">
                @foreach ($baseImages as $baseImage)
                    <option value="{{ $baseImage }}">{{ $baseImage }}</option>
                @endforeach
            </x-input.select>
        </x-input.group>
    </div>
</x-form>
