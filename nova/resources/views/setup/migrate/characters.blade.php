@extends('layouts.setup')

@section('title', 'Verify Character Data')

@section('header', 'Verify Character Data')

@section('content')
	<h1>Verify Character Data</h1>
	<h3>Let's make sure all of your character data is right.</h3>

	<div class="row" v-cloak>
		<div class="col-lg-10 col-xl-9 mx-auto">
			<div class="data-table bordered striped">
				<div class="row align-items-center" v-for="character in characters" v-if="!character.finished">
					<div class="col-md-6 d-flex align-items-center">
						<a href="#"
						   class="text-muted mr-2"
						   @click.prevent="character.finished = true">
						   <i class="fa fa-check"></i>
						</a>
						<avatar :item="character" type="nothing" :show-status="false"></avatar>
					</div>
					<div class="col-md-6">
						<rank-picker :selected="character.rank" :initial-ranks="{{ $ranks }}"></rank-picker>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('controls')
	<a href="{{ route('setup.'.$_setupType.'.settings') }}" class="btn btn-primary btn-lg">
		Next: Update {{ config('nova.app.name') }} Settings
	</a>
	<a href="{{ route('setup.'.$_setupType.'.nova') }}" class="btn btn-link-secondary btn-lg">
		Back: Migrate Nova 2
	</a>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				characters: {!! $characters !!},
				updateData: []
			},

			methods: {
				updateCharacter (id, rank) {
					this.updateData.push({ id: id, rank: rank});
				}
			}
		};
	</script>
@endsection