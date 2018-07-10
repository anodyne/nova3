@extends('layouts.welcome')

@section('content')
	<div class="title m-b-md">
		Nova NextGen
	</div>

	<div class="links m-b-md">
		<a href="https://help.anodyne-productions.com/product/nova-3" target="_blank">Documentation</a>
		<a href="http://anodyne-productions.com/nova/nextgen" target="_blank">Preview Site</a>
		<a href="https://github.com/anodyne/nova3" target="_blank">GitHub</a>
		<a href="http://anodyne-productions.com" target="_blank">Anodyne</a>
	</div>

	@if (auth()->check())
		<div class="links">
			<strong>Signed In as</strong> {{ $_user->name }} ({{ $_user->email }})
		</div>
	@endif
@endsection
