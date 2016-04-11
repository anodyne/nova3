@if ($forms->count() > 0)
	<div class="row">
		<div class="col-md-3">
			<div class="list-group">
				@foreach ($forms as $form)
					<a href="#" class="list-group-item" data-form-key="{{ $form->key }}" @click.prevent="getForm">{!! $form->present()->name !!}</a>
				@endforeach
			</div>
		</div>

		<div class="col-md-9 form-center-container">
			<div class="form-center-loader" v-show="loading">
				<h4 class="text-center">{!! HTML::image('nova/resources/images/ajax-loader.gif') !!}</h4>
			</div>
			<div class="form-center-initial" v-show="!hasContent">
				{!! alert('info', "Select a form from the menu to continue") !!}
			</div>
			<div class="form-center-content" v-show="!loading"></div>
		</div>
	</div>
@else
	{!! alert('warning', "No Form Center forms found") !!}
@endif