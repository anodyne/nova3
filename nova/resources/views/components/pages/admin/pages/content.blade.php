<div v-cloak>
	<mobile>
		@can('create', $content)
			<p><a href="{{ route('admin.content.create') }}" class="btn btn-success btn-lg btn-block">{!! icon('add') !!}<span>Add Content</span></a></p>
		@endcan

		<p><a href="{{ route('admin.pages') }}" class="btn btn-secondary btn-lg btn-block">{!! icon('file') !!}<span>Manage Pages</span></a></p>
	</mobile>

	<div v-if="contents.length == 0">
		{!! alert('warning', "No additional page content found.") !!}
	</div>
	<div v-else>
		<div class="data-table bordered striped">
			<div class="row header">
				<div class="col">
					<div class="input-group">
						{!! Form::text('searchName', null, ['class' => 'form-control', 'v-model' => 'search', 'placeholder' => _m('pages-filter')]) !!}
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button" @click.prevent="resetFilters">{!! icon('close') !!}</button>
						</span>
					</div>
				</div>
				<div class="col-md-6">
					<desktop>
						<div class="btn-toolbar pull-right">
							@can('create', $content)
								<div class="btn-group">
									<a href="{{ route('admin.content.create') }}" class="btn btn-success">{!! icon('add') !!}<span>Add Content</span></a>
								</div>
							@endcan

							<div class="btn-group">
								<a href="{{ route('admin.pages') }}" class="btn btn-secondary">{!! icon('file') !!}<span>Manage Pages</span></a>
							</div>
						</div>
					</desktop>
				</div>
			</div>
			<div class="row" v-for="content in contents">
				<div class="col-md-9">
					<p>@{{ content.preview }}</p>
					<p><strong>Key:</strong> @{{ content.key }}</p>
				</div>
				<div class="col-md-3">
					<mobile>
						<div class="row">
							@can('edit', $content)
								<div class="col-sm-6">
									<p><a href="content.links.edit" class="btn btn-secondary btn-lg btn-block">{!! icon('edit') !!}<span>Edit</span></a></p>
								</div>
							@endcan

							@can('remove', $content)
								<div class="col-sm-6" v-show="!content.protected">
									<p><a class="btn btn-danger btn-lg btn-block" @click="removeContent(content.id)">{!! icon('delete') !!}<span>Remove</span></a></p>
								</div>
							@endcan
						</div>
					</mobile>
					<desktop>
						<div class="btn-toolbar pull-right">
							@can('edit', $content)
								<div class="btn-group">
									<a href="content.links.edit" class="btn btn-secondary">{!! icon('edit') !!}<span>Edit</span></a>
								</div>
							@endcan

							@can('remove', $content)
								<div class="btn-group" v-show="!content.protected">
									<a class="btn btn-danger" @click="removeContent(content.id)">{!! icon('delete') !!}<span>Remove</span></a>
								</div>
							@endcan
						</div>
					</desktop>
				</div>
			</div>
		</div>
	</div>
</div>

@can('remove', $content)
	{!! modal(['id' => "removeContent", 'header' => "Remove Page Content"]) !!}
@endcan