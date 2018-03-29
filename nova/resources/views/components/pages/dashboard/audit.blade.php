<h1>Audit</h1>

<div class="form-group">
	<input type="search" placeholder="Filter activity logs" class="form-control" v-model="search">
</div>

<ul>
	<li v-for="log in filteredLogs">
		@{{ log.description }}<br>
		<span class="text-muted" style="font-variant:small-caps;" v-html="log.subject_type"></span>
	</li>
</ul>