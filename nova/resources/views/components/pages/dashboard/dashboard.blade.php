<h1>Dashboard</h1>

{{-- <div class="alert is-warning with-icon">
	<icon name="warning"></icon>
	<span>Welcome to Nova NextGen's dashboard! The dashboard is currently under construction and will be built out through the development process. If you have suggestions about things that should be on the dashboard, let us know.</span>
</div> --}}

@php($items = collect([['id' => 'one','value' => 'one'], ['id' => 'two','value' => 'two'], ['id' => 'three','value' => 'three']]))

<pick-list :items="{{ $items->toJson() }}">
	<template slot="picker-nothing-selected">Select a value to begin</template>
	<template slot="picker-selected-item" slot-scope="props">@{{ props.item.value }}</template>

	<template slot="picker-list-item" slot-scope="props">@{{ props.item.value }}</template>
</pick-list>

{{-- @include('pages.dashboard._checklist-install')
@include('pages.dashboard._checklist-migrate') --}}
