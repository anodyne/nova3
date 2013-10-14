<div class="row" id="value_{{ $id }}">
	<div class="col-xs-12 col-sm-9 col-lg-9">
		<p>{{ Form::text('', $value, ['class' => 'form-control']) }}</p>
	</div>
	<div class="col-xs-12 col-sm-3 col-lg-3">
		<div class="visible-lg">
			<div class="btn-toolbar sm-btn-toolbar pull-right">
				<div class="btn-group">
					<a href="#" class="btn btn-sm btn-default js-value-action icn-size-16 tooltip-top" title="{{ lang('Action.save') }}" data-action="update" data-id="{{ $id }}">{{ $icons['check'] }}</a>
				</div>
				<div class="btn-group">
					<a href="#" class="btn btn-sm btn-danger js-value-action icn-size-16" data-action="delete" data-id="{{ $id }}">{{ $icons['remove'] }}</a>
				</div>
			</div>
		</div>
		<div class="hidden-lg">
			<p><a href="#" class="btn btn-block btn-default js-value-action icn-size-16" data-action="update" data-id="{{ $id }}">{{ $icons['check'] }}</a></p>

			<p><a href="#" class="btn btn-block btn-danger js-value-action icn-size-16" data-action="delete" data-id="{{ $id }}">{{ $icons['remove'] }}</a></p>
		</div>
	</div>
</div>