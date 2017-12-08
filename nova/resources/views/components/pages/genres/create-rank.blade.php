<h1>{{ _m('genre-ranks-add') }}</h1>

{!! Form::open(['route' => 'ranks.items.store']) !!}
	<div class="row">
		<div class="col-12 col-md-3">
			<div class="form-group">
				<label>{{ _m('preview') }}</label>
				<div v-if="base == '' && overlay == ''">
					<small class="text-warning">{{ _m('genre-ranks-build') }}</small>
				</div>
				<div v-else>
					<rank :base="base" :overlay="overlay"></rank>
				</div>
			</div>

			<div class="form-group">
				<input type="hidden" name="base" v-model="base">
				<input type="hidden" name="overlay" v-model="overlay">

				<p><button type="submit" class="btn btn-block btn-primary">{{ _m('genre-ranks-add') }}</button></p>
				<a href="{{ route('ranks.items.index') }}" class="btn btn-block btn-link">{{ _m('cancel') }}</a>
			</div>
		</div>

		<div class="col-12 col-md-9">
			<div id="accordion" class="accordion" role="tablist" aria-multiselectable="true">
				<div class="card mb-2">
					<div class="card-header d-flex align-items-center justify-content-end" role="tab" id="rankInfoHeading">
						<h5 class="mb-0 mr-auto">
							<a data-toggle="collapse"
							   data-parent="#accordion"
							   href="#rankInfo"
							   aria-expanded="true"
							   aria-controls="rankInfo"
							   @click="accordion = 'info'">
								{{ _m('basic-info') }}
							</a>
						</h5>
						<a href="#rankBaseImage"
							   class="btn btn-action"
							   data-toggle="collapse"
							   data-parent="#accordion"
							   v-show="accordion == 'info'"
							   @click="accordion = 'base'">{!! icon('arrow-right') !!}</a>
					</div>
					<div id="rankInfo" class="collapse show" role="tabpanel" aria-labelledby="rankInfoHeading">
						<div class="card-body">
							<div class="form-group{{ $errors->has('group_id') ? ' has-danger' : '' }}">
								<label>{{ _m('genre-rank-groups', [1]) }}</label>
								<div class="d-flex align-items-center">
									{!! Form::select('group_id', $groups, null, ['class' => 'custom-select', 'placeholder' => _m('genre-rank-groups-select')]) !!}
									<a href="{{ route('ranks.groups.create') }}" class="btn btn-link" data-toggle="tooltip" title="{{ _m('genre-rank-groups-add') }}">{!! icon('add-alt') !!}</a>
								</div>
								{!! $errors->first('group_id', '<p class="form-control-feedback">:message</p>') !!}
							</div>

							<div class="form-group{{ $errors->has('info_id') ? ' has-danger' : '' }}">
								<label>{{ _m('genre-rank-info') }}</label>
								<div class="d-flex align-items-center">
									{!! Form::select('info_id', $info, null, ['class' => 'custom-select', 'placeholder' => _m('genre-rank-info-select')]) !!}
									<a href="{{ route('ranks.info.create') }}" class="btn btn-link" data-toggle="tooltip" title="{{ _m('genre-rank-info-add') }}">{!! icon('add-alt') !!}</a>
								</div>
								{!! $errors->first('info_id', '<p class="form-control-feedback">:message</p>') !!}
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-2">
					<div class="card-header d-flex align-items-center justify-content-end" role="tab" id="rankBaseImageHeading">
						<h5 class="mb-0 mr-auto">
							<a class="collapsed"
							   data-toggle="collapse"
							   data-parent="#accordion"
							   href="#rankBaseImage"
							   aria-expanded="false"
							   aria-controls="rankBaseImage"
							   @click="accordion = 'base'">
								{{ _m('genre-ranks-image-base') }}
							</a>
						</h5>
						<div v-show="accordion == 'base'">
							<a href="#rankInfo"
							   class="btn btn-action"
							   data-toggle="collapse"
							   data-parent="#accordion"
							   @click="accordion = 'info'">{!! icon('arrow-left') !!}</a>
							<a href="#rankOverlayImage"
							   class="btn btn-action"
							   data-toggle="collapse"
							   data-parent="#accordion"
							   @click="accordion = 'overlay'">{!! icon('arrow-right') !!}</a>
						</div>
					</div>
					<div id="rankBaseImage" class="collapse" role="tabpanel" aria-labelledby="rankBaseImageHeading">
						<div class="card-body">
							<div class="row">
								@foreach ($baseImages as $key => $bImage)
									@if (is_array($bImage))
										<div class="col-12 mb-2">
											<h3>{{ $key }}</h3>
										</div>
										@foreach ($bImage as $baseImg)
											<div class="col col-auto mb-3" :class="baseSelector('{{ $baseImg }}')">
												<a href="#"
												   class="d-flex flex-column text-center"
												   @click.prevent="changeImage('base', '{{ $baseImg }}')">
												   {!! HTML::image('ranks/'.Settings::item('rank')->first()->value.'/base/'.$baseImg) !!}
												   <small>{{ $baseImg }}</small>
												</a>
											</div>
										@endforeach
									@else
										<div class="col col-auto mb-3" :class="baseSelector('{{ $bImage }}')">
											<a href="#"
											   class="d-flex flex-column text-center"
											   @click.prevent="changeImage('base', '{{ $bImage }}')">
											   {!! HTML::image('ranks/'.Settings::item('rank')->first()->value.'/base/'.$bImage) !!}
											   <small>{{ $bImage }}</small>
											</a>
										</div>
									@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-end" role="tab" id="rankOverlayImageHeading">
						<h5 class="mb-0 mr-auto">
							<a class="collapsed"
							   data-toggle="collapse"
							   data-parent="#accordion"
							   href="#rankOverlayImage"
							   aria-expanded="false"
							   aria-controls="rankOverlayImage"
							   @click="accordion = 'overlay'">
								{{ _m('genre-ranks-image-overlay') }}
							</a>
						</h5>
						<a href="#rankBaseImage"
							   class="btn btn-action"
							   data-toggle="collapse"
							   data-parent="#accordion"
							   v-show="accordion == 'overlay'"
							   @click="accordion = 'base'">{!! icon('arrow-left') !!}</a>
					</div>
					<div id="rankOverlayImage" class="collapse" role="tabpanel" aria-labelledby="rankOverlayImageHeading">
						<div class="card-body">
							<div class="row">
								@foreach ($overlayImages as $key => $oImage)
									@if (is_array($oImage))
										<div class="col-12 mb-2">
											<h3>{{ $key }}</h3>
										</div>
										@foreach ($oImage as $overlayImg)
											<div class="col col-auto mb-3" :class="overlaySelector('{{ $overlayImg }}')">
												<a href="#"
												   class="d-flex flex-column text-center"
												   @click.prevent="changeImage('overlay', '{{ $overlayImg }}')">
												   {!! HTML::image('ranks/'.Settings::item('rank')->first()->value.'/overlay/'.$overlayImg) !!}
												   <small>{{ $overlayImg }}</small>
												</a>
											</div>
										@endforeach
									@else
										<div class="col col-auto mb-3" :class="overlaySelector('{{ $oImage }}')">
											<a href="#"
											   class="d-flex flex-column text-center"
											   @click.prevent="changeImage('overlay', '{{ $oImage }}')">
											   {!! HTML::image('ranks/'.Settings::item('rank')->first()->value.'/overlay/'.$oImage) !!}
											   <small>{{ $oImage }}</small>
											</a>
										</div>
									@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
{!! Form::close() !!}