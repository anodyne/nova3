<page-header>
	<template slot="pretitle">Themes</template>
	<template slot="title">Edit Theme</template>
</page-header>

<form action="{{ route('themes.store') }}" method="post">
	<div class="mb-6">
		<label class="block font-medium mb-1">Name</label>
		<input name="name" class="w-1/2 p-2 rounded border bg-transparent" value="{{ $theme->name }}">
	</div>

	<div class="mb-6">
		<label class="block font-medium mb-1">Path</label>
		<input name="path" class="w-1/2 p-2 rounded border bg-transparent" value="{{ $theme->path }}">
	</div>

	<fieldset class="mb-6">
		<legend class="font-light text-2xl mb-4">Admin Pages</legend>
		<div class="mx-4">
			<label class="block font-medium mb-1">Layout</label>
			<layout-picker section="app"></layout-picker>
		</div>
	</fieldset>

	<fieldset class="mb-6">
		<legend class="font-light text-2xl mb-4">Authentication Pages</legend>
		<div class="mx-4">
			<label class="block font-medium mb-1">Layout</label>
			<layout-picker section="auth"></layout-picker>
		</div>
	</fieldset>

	<div class="mb-6">
		<label class="block font-medium mb-1">Site Pages Layout</label>
		<select name="layout_site" class="w-1/2 p-2 rounded border bg-transparent">
			<option value="app-sidebar" {{ $theme->layout_site == 'app-sidebar' ? 'selected' : '' }}>Sidebar</option>
			<option value="app-sidebar-topnav" {{ $theme->layout_site == 'app-sidebar-topnav' ? 'selected' : '' }}>Sidebar w/ top nav</option>
			<option value="app-topnav" {{ $theme->layout_site == 'app-topnav' ? 'selected' : '' }}>Top nav</option>
			<option value="app-landing" {{ $theme->layout_site == 'app-landing' ? 'selected' : '' }}>Landing</option>
		</select>
	</div>

	<div class="mb-6">
		<label class="block font-medium mb-1">Landing Pages Layout</label>
		<select name="layout_landing" class="w-1/2 p-2 rounded border bg-transparent">
			<option value="app-sidebar" {{ $theme->layout_landing == 'app-sidebar' ? 'selected' : '' }}>Sidebar</option>
			<option value="app-sidebar-topnav" {{ $theme->layout_landing == 'app-sidebar-topnav' ? 'selected' : '' }}>Sidebar w/ top nav</option>
			<option value="app-topnav" {{ $theme->layout_landing == 'app-topnav' ? 'selected' : '' }}>Top nav</option>
			<option value="app-landing" {{ $theme->layout_landing == 'app-landing' ? 'selected' : '' }}>Landing</option>
		</select>
	</div>

	<div class="mb-6">
		<label class="block font-medium mb-1">Authentication Pages Layout</label>
		<select name="layout_auth" class="w-1/2 p-2 rounded border bg-transparent">
			<option value="auth-basic" {{ $theme->layout_auth == 'auth-basic' ? 'selected' : '' }}>Basic</option>
			<option value="auth-cover" {{ $theme->layout_auth == 'auth-cover' ? 'selected' : '' }}>Cover photo</option>
			<option value="auth-illustration" {{ $theme->layout_auth == 'auth-illustration' ? 'selected' : '' }}>Illustration</option>
		</select>
	</div>

	<div>
		<button type="submit" class="button is-primary">
			<span>Update</span>
			<icon name="check-alt" class="btn-icon"></icon>
		</button>
	</div>
</form>
