@extends('layouts.app')

@section('title', _m('genre-depts-reorder'))

@section('content')
	<h1>{{ _m('genre-depts-reorder') }}</h1>

	@if ($departments->count() > 0)
		<p><a href="{{ route('departments.index') }}" class="btn btn-secondary">{{ _m('genre-depts-manage') }}</a></p>

		<div id="sortable">
			@foreach ($departments as $dept)
				<div class="card mb-3" data-id="{{ $dept->id }}">
					<div class="card-block">
						<div class="d-flex align-items-center">
							<span class="sortable-handle text-subtle mr-2">{!! icon('reorder') !!}</span>
							<span>{{ $dept->name }}</span>
						</div>

						@if ($dept->subDepartments->count() > 0)
							<ul class="mb-0 sub-sortable list-unstyled" data-group="{{ strtolower(str_replace(' ', '_', $dept->name)) }}">
								@foreach ($dept->subDepartments as $subDept)
									<li class="ml-4 py-2 d-flex align-items-cente" data-id="{{ $subDept->id }}">
										<span class="sortable-handle text-subtle mr-2">{!! icon('reorder') !!}</span>
										<span>{{ $subDept->name }}</span>
									</li>
								@endforeach
							</ul>
						@endif
					</div>
				</div>
			@endforeach
		</ul>
	@else
		<div class="alert alert-warning">
			{{ _m('genre-depts-error-not-found') }} <a href="{{ route('departments.create') }}" class="alert-link">{{ _m('genre-depts-error-add') }}</a>
		</div>
	@endif
@endsection

@section('js')
	<script>
		vue = {
			mounted () {
				Sortable.create(document.getElementById('sortable'), {
					handle: '.sortable-handle',
					onEnd (event) {
						handleOnEnd(event)
					}
				})

				$('.sub-sortable').each(function () {
					Sortable.create(this, {
						handle: '.sortable-handle',
						group: {
							name: $(this).data('group'),
							pull: false,
							put: true
						},
						onEnd (event) {
							handleOnEnd(event)
						}
					})
				})
			}
		}

		function handleOnEnd (event) {
			let order = new Array()

			$(event.from).children().each(function () {
				let id = $(this).data('id')

				if (id) {
					order.push(id)
				}
			})

			axios.patch(route('departments.reorder'), {
				depts: order
			})
		}
	</script>
@endsection