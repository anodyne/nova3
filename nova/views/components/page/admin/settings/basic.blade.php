@if ($settings->count() > 0)
	@foreach ($settings as $s)
		<div class="row">
			<div class="col-sm-6 col-lg-4">
				@if (empty($s->help))
					<div class="form-group">
				@endif

				<label class="control-label">{{ $s->label }}</label>
				<div class="controls">{{ Form::text($s->key, $s->value) }}</div>

				@if (empty($s->help))
					</div>
				@endif
			</div>
		</div>
		@if ( ! empty($s->help))
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ Markdown::parse($s->help) }}</p>
				</div>
			</div>
		@endif
	@endforeach
@else
	{{ partial('common/alert', ['content' => lang('error.notFound', lang('settings'))]) }}
@endif