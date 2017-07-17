@extends('layouts.app')

@section('title', _m('genre-rank-add'))

@section('content')
	<h1>{{ _m('genre-rank-add') }}</h1>

	{!! Form::open(['route' => 'ranks.items.store']) !!}
		<div class="row mb-4">
			<div class="col-md-6">
				<div class="form-group{{ $errors->has('group_id') ? ' has-danger' : '' }}">
					<label class="form-control-label">{{ _m('genre-rank-group') }}</label>
					<div>
						{!! Form::select('group_id', $groups, null, ['class' => 'custom-select', 'placeholder' => _m('genre-rank-groups-select')]) !!}
					</div>
					{!! $errors->first('group_id', '<p class="form-control-feedback">:message</p>') !!}
				</div>

				<div class="form-group{{ $errors->has('info_id') ? ' has-danger' : '' }}">
					<label class="form-control-label">{{ _m('genre-rank-info') }}</label>
					<div>
						{!! Form::select('info_id', $info, null, ['class' => 'custom-select', 'placeholder' => _m('genre-rank-info-select')]) !!}
					</div>
					{!! $errors->first('info_id', '<p class="form-control-feedback">:message</p>') !!}
				</div>

				<input type="hidden" name="base" v-model="base">
				<input type="hidden" name="overlay" v-model="overlay">

				<div class="form-group">
					<button type="submit" class="btn btn-primary">{{ _m('genre-rank-add') }}</button>
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

		<ul class="nav nav-pills" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#base" role="tab">{{ _m('genre-rank-image-base') }}</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#overlay" role="tab">{{ _m('genre-rank-image-overlay') }}</a>
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
							<div class="col-6 col-md-3 mb-3">
								<a href="#" @click.prevent="base = '{{ $baseImg }}'">{!! HTML::image('ranks/st24/duty/base/'.$baseImg) !!}</a>
							</div>
						@endforeach
					@else
						<div class="col-6 col-md-3 mb-3">
							<a href="#" @click.prevent="base = '{{ $bImage }}'">{!! HTML::image('ranks/st24/duty/base/'.$bImage) !!}</a>
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
							<div class="col-6 col-md-3 mb-3">
								<a href="#" @click.prevent="overlay = '{{ $overlayImg }}'">{!! HTML::image('ranks/st24/duty/overlay/'.$overlayImg) !!}</a>
							</div>
						@endforeach
					@else
						<div class="col-6 col-md-3 mb-3">
							<a href="#" @click.prevent="overlay = '{{ $oImage }}'">{!! HTML::image('ranks/st24/duty/overlay/'.$oImage) !!}</a>
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
					return 'background-image:url(/ranks/st24/duty/base/' + this.base + ')'
				},

				overlayStyles () {
					return 'background-image:url(/ranks/st24/duty/overlay/' + this.overlay + ')'
				}
			}
		}
	</script>
@endsection