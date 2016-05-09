<div v-cloak>
	<mobile>
		<p><a href="#" class="btn btn-default btn-lg btn-block" @click.prevent="switchToEntries">{!! icon('close') !!}<span>Close</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="#" class="btn btn-default" @click.prevent="switchToEntries">{!! icon('close') !!}<span>Close</span></a>
			</div>
		</div>
	</desktop>
</div>

{!! $form->present()->renderEditForm($entry->id) !!}