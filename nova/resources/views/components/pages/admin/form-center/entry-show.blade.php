<div v-cloak>
	<mobile>
		<p><a href="#" class="btn btn-default btn-lg btn-block" @click.prevent="switchToEntries">Close</a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="#" class="btn btn-default" @click.prevent="switchToEntries">Close</a>
			</div>
		</div>
	</desktop>
</div>

{!! $form->present()->renderViewForm($entry->id) !!}