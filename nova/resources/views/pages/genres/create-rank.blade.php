@extends('layouts.app')

@section('title', _m('genre-ranks-add'))

@section('content')
	<h1>{{ _m('genre-ranks-add') }}</h1>

	{!! Form::open(['route' => 'ranks.items.store']) !!}
		<div class="row mb-4">
			<div class="col-md-6">
				<div class="form-group{{ $errors->has('group_id') ? ' has-danger' : '' }}">
					<label class="form-control-label">{{ _m('genre-rank-groups', [1]) }}</label>
					<div class="d-flex align-items-center">
						{!! Form::select('group_id', $groups, null, ['class' => 'custom-select', 'placeholder' => _m('genre-rank-groups-select')]) !!}
						<a href="{{ route('ranks.groups.create') }}" class="btn btn-link" data-toggle="tooltip" title="{{ _m('genre-rank-groups-add') }}">{!! icon('add-alt') !!}</a>
					</div>
					{!! $errors->first('group_id', '<p class="form-control-feedback">:message</p>') !!}
				</div>

				<div class="form-group{{ $errors->has('info_id') ? ' has-danger' : '' }}">
					<label class="form-control-label">{{ _m('genre-rank-info') }}</label>
					<div class="d-flex align-items-center">
						{!! Form::select('info_id', $info, null, ['class' => 'custom-select', 'placeholder' => _m('genre-rank-info-select')]) !!}
						<a href="{{ route('ranks.info.create') }}" class="btn btn-link" data-toggle="tooltip" title="{{ _m('genre-rank-info-add') }}">{!! icon('add-alt') !!}</a>
					</div>
					{!! $errors->first('info_id', '<p class="form-control-feedback">:message</p>') !!}
				</div>

				<input type="hidden" name="base" v-model="base">
				<input type="hidden" name="overlay" v-model="overlay">

				<div class="form-group">
					<button type="submit" class="btn btn-primary">{{ _m('genre-ranks-add') }}</button>
					<a href="{{ route('ranks.items.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="form-control-label">{{ _m('preview') }}</label>
					<rank :base="base" :overlay="overlay"></rank>
				</div>
			</div>
		</div>

		<ul class="nav nav-pills" id="rank-images" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#base" role="tab">{{ _m('genre-ranks-image-base') }}</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#overlay" role="tab">{{ _m('genre-ranks-image-overlay') }}</a>
			</li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active p-3" id="base" role="tabpanel">
				<div class="row">
				@foreach ($baseImages as $key => $bImage)
					@if (is_array($bImage))
						<div class="col-12 mb-2">
							<h3>{{ $key }}</h3>
						</div>
						@foreach ($bImage as $baseImg)
							<div class="col col-auto mb-3" :class="baseSelector('{{ $baseImg }}')">
								<a href="#" @click.prevent="changeImage('base', '{{ $baseImg }}')">{!! HTML::image('ranks/'.config('nova.genre').'/duty/base/'.$baseImg) !!}</a>
							</div>
						@endforeach
					@else
						<div class="col col-auto mb-3" :class="baseSelector('{{ $bImage }}')">
							<a href="#" @click.prevent="changeImage('base', '{{ $bImage }}')">{!! HTML::image('ranks/'.config('nova.genre').'/duty/base/'.$bImage) !!}</a>
						</div>
					@endif
				@endforeach
				</div>
			</div>
			<div class="tab-pane p-3" id="overlay" role="tabpanel">
				<div class="row">
				@foreach ($overlayImages as $key => $oImage)
					@if (is_array($oImage))
						<div class="col-12 mb-2">
							<h3>{{ $key }}</h3>
						</div>
						@foreach ($oImage as $overlayImg)
							<div class="col col-auto mb-3" :class="overlaySelector('{{ $overlayImg }}')">
								<a href="#" @click.prevent="changeImage('overlay', '{{ $overlayImg }}')">{!! HTML::image('ranks/'.config('nova.genre').'/duty/overlay/'.$overlayImg) !!}</a>
							</div>
						@endforeach
					@else
						<div class="col col-auto mb-3" :class="overlaySelector('{{ $oImage }}')">
							<a href="#" @click.prevent="changeImage('overlay', '{{ $oImage }}')">{!! HTML::image('ranks/'.config('nova.genre').'/duty/overlay/'.$oImage) !!}</a>
						</div>
					@endif
				@endforeach
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@endsection

@section('js')
	<script>
		vue = {
			data: {
				base: '',
				overlay: ''
			},

			computed: {
				baseStyles () {
					return 'background-image:url(/ranks/' + {{ config('nova.genre') }} + '/duty/base/' + this.base + ')'
				},

				overlayStyles () {
					return 'background-image:url(/ranks/' + {{ config('nova.genre') }} + '/duty/overlay/' + this.overlay + ')'
				}
			},

			methods: {
				baseSelector (image) {
					return ['rank-selector', (image == this.base) ? 'selected' : '']
				},

				changeImage (type, image) {
					if (type == 'base') {
						this.base = image

						$('#rank-images a:last').tab('show')
					}

					if (type == 'overlay') {
						this.overlay = image
					}
				},

				overlaySelector (image) {
					return ['rank-selector', (image == this.overlay) ? 'selected' : '']
				}
			}
		}
	</script>
@endsection