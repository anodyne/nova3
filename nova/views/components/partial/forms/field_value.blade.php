<div class="row">
	<div class="col-xs-12 col-sm-8 col-lg-8">
		<p>{{ Form::text('', $value, ['class' => 'form-control']) }}</p>
	</div>
	<div class="col-xs-6 col-sm-2 col-lg-2">
		<div class="visible-lg">
			<p class="pull-right"><a href="#" class="btn btn-sm btn-default js-value-action icn-size-16 tooltip-top" title="{{ lang('Action.save') }}" data-action="update" data-id="{{ $id }}">{{ $icons['check'] }}</a></p>
		</div>
		<div class="hidden-lg">
			<p><a href="#" class="btn btn-block btn-default js-value-action icn-size-16" data-action="update" data-id="{{ $id }}">{{ $icons['check'] }}</a></p>
		</div>
	</div>
	<div class="col-xs-6 col-sm-2 col-lg-2">
		<div class="visible-lg">
			<p><a href="#" class="btn btn-sm btn-danger js-value-action icn-size-16" data-action="delete" data-id="{{ $id }}">{{ $icons['remove'] }}</a></p>
		</div>
		<div class="hidden-lg">
			<p><a href="#" class="btn btn-block btn-danger js-value-action icn-size-16" data-action="delete" data-id="{{ $id }}">{{ $icons['remove'] }}</a></p>
		</div>
	</div>
</div>