<div class="btn-group">
	<a href="{{ URL::to('admin/form') }}" class="btn btn-default icn-size-16 tooltip-top" title="{{ lang('Short.back', lang('forms')) }}">{{ $_icons['back'] }}</a>
</div>

@if ($forms->count() > 0)
	<div class="row">
	@foreach ($forms as $form)
		<div class="col col-lg-6">
			<div class="thumbnail">
				<div class="btn-group pull-right">
					<a class="btn btn-default btn-small icn-size-16 tooltip-top" title="{{ lang('Short.view', langConcat('all entries')) }}" href="{{ URL::to('admin/form/view/'.$form->key) }}">{{ $_icons['forward'] }}</a>
				</div>

				<h4>{{ $form->name }}</h4>
			</div>
		</div>
	@endforeach
	</div>
@else
	{{ partial('common/alert', ['content' => lang('error.notFound', lang('forms'))]) }}
@endif