<div class="data-table data-table-striped data-table-bordered">
	<div class="row dt-header">
		<div class="col">
			<div class="input-group">
				<input type="search" placeholder="Search" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-secondary">{!! icon('close') !!}</button>
				</span>
			</div>
		</div>
		<div class="col-7">
			<div class="btn-toolbar pull-right">
				<div class="btn-group">
					<button class="btn btn-outline-success">Add a Page</button>
				</div>
				<div class="btn-group">
					<button class="btn btn-outline-danger">Remove All</button>
				</div>
			</div>
		</div>
	</div>

	@for ($i=0; $i<5; $i++)
		<div class="row">
			<div class="col">
				<p>Column #1</p>
			</div>
			<div class="col">
				<p>Column #2</p>
			</div>
			<div class="col">
				<p>Column #3</p>
			</div>
		</div>
	@endfor
</div>