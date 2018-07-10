<page-header>
	<template slot="pretitle">Themes</template>
	<template slot="title">Create a Theme</template>
</page-header>

<form action="{{ route('themes.store') }}" method="post">
	<div class="mb-6">
		<label class="block font-medium mb-1">Name</label>
		<input name="name" class="w-1/2 p-2 rounded border bg-transparent">
	</div>

	<div class="mb-6">
		<label class="block font-medium mb-1">Path</label>
		<input name="path" class="w-1/2 p-2 rounded border bg-transparent">
	</div>

	<div>
		<button type="submit" class="button is-primary">Submit</button>
	</div>
</form>
