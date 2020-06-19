@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Rank Item">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.items.index') }}">Rank Items</a>
        </x-slot>
    </x-page-header>

    <x-panel x-data="{ tab: 'base', base: '', overlay: '' }">
        <x-form :action="route('ranks.items.store')">
            <x-form.section title="Rank Info" message="Rank names allow you to re-use basic rank information across all of your ranks to avoid unnecessary and tedious editing of the same information across every rank in the system.">
                <x-input.group label="Rank Group" for="group_id" :error="$errors->first('group_id')">
                    <select name="group_id" id="group_id" class="form-select w-full | sm:w-1/2">
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </x-input.group>

                <x-input.group label="Rank Name" for="name_id" :error="$errors->first('name_id')">
                    <select name="name_id" id="name_id" class="form-select w-full | sm:w-1/2">
                        @foreach ($names as $name)
                            <option value="{{ $name->id }}">{{ $name->name }}</option>
                        @endforeach
                    </select>
                </x-input.group>

                <x-input.group label="Rank Preview">
                    <x-rank base="@{{ base }}" />

                    <div class="relative overflow-hidden">
                        <div class="absolute" x-bind:style="`width:144px; height:40px; top:-4px; background: url(/ranks/overlay/${overlay}) top left;`"></div>
                        <div x-bind:style="`width:144px; height:40px; background: url(/ranks/base/${base}) top left;`"></div>
                    </div>
                </x-input.group>
            </x-form.section>

            <div class="border-t border-gray-100 mt-10 px-4 pt-4 | sm:px-6 sm:pt-6">
                <div>
                    <div class="sm:hidden">
                        <select aria-label="Selected tab" class="form-select block w-full">
                            <option>My Account</option>
                            <option>Company</option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <nav class="flex">
                            <a href="#" x-on:click.prevent="tab = 'base'" class="ml-4 first:ml-0 px-3 py-2 font-medium text-sm leading-5 rounded-md text-primary-700 bg-primary-100 focus:outline-none focus:text-primary-800 focus:bg-primary-200">
                                Base Images
                            </a>
                            <a href="#" x-on:click.prevent="tab = 'overlay'" class="ml-4 px-3 py-2 font-medium text-sm leading-5 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none focus:text-primary-600 focus:bg-primary-50">
                                Overlay Images
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="mt-6 | sm:h-72 sm:overflow-y-scroll">
                    <div x-show="tab === 'base'">
                        <div class="grid gap-6 max-w-lg mx-auto | lg:grid-cols-4 lg:max-w-none">
                            @foreach ($baseImages as $baseImage)
                                <a href="#" x-on:click.prevent="base = '{{ $baseImage }}'" class="rounded-md border border-transparent py-2 flex justify-center hover:bg-gray-100 hover:border-gray-200">
                                    <img src="{{ asset('ranks/base/' . $baseImage) }}" alt="" class="block">
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div x-show="tab === 'overlay'">
                        <div class="grid gap-6 max-w-lg mx-auto | lg:grid-cols-4 lg:max-w-none">
                            @foreach ($overlayImages as $overlayImage)
                                <a href="#" x-on:click.prevent="overlay = '{{ $overlayImage }}'" class="rounded-md border border-transparent py-2 flex justify-center hover:bg-gray-100 hover:border-gray-200">
                                    <img src="{{ asset('ranks/overlay/' . $overlayImage) }}" alt="" class="block">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            <x-form.footer>
                <button type="submit" class="button button-primary">Add Rank Item</button>

                <a href="{{ route('ranks.items.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
