<p>Are you sure you want to remove the <strong>{{ $section->present()->name }}</strong> section from the <em>{{ $form->present()->name }}</em> form? This action is permanent and can't be undone!</p>

{!! Form::model($section, ['route' => ['admin.forms.sections.destroy', $form->key, $section->id], 'method' => 'delete', 'id' => 'ajax']) !!}
	<div class="form-group">
		<div class="">
			<div class="checkbox">
				<label>
					{!! Form::checkbox('remove_section_content', true, false, ['v-model' => 'removeSectionContent']) !!}
					<strong>Delete All Section Content?</strong>
				</label>
			</div>
		</div>
	</div>

	<div class="form-group" v-if="removeSectionContent == false">
		<label class="control-label">New Section</label>
		{!! Form::select('new_section', $sections, 0, ['class' => 'form-control input-lg', 'v-model' => 'newSection']) !!}
		<p class="help-block">Select the new section that you want any fields currently assigned to the {{ $section->present()->name }} section to be reassigned to.</p>
	</div>

	<div v-cloak>
		<phone-tablet>
			<p>{!! Form::button("Remove Form Section", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
			<p>{!! Form::button("Cancel", ['class' => 'btn btn-default btn-lg btn-block', 'data-dismiss' => 'modal']) !!}</p>
		</phone-tablet>
		<desktop>
			{!! Form::button("Remove Form Section", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}
			{!! Form::button("Cancel", ['class' => 'btn btn-link-default btn-lg', 'data-dismiss' => 'modal']) !!}
		</desktop>
	</div>
{!! Form::close() !!}

<script>
	new Vue({
		el: '#ajax',

		data: {
			newSection: 0,
			removeSectionContent: false
		},

		watch: {
			removeSectionContent: function (value, oldValue) {
				if (value == true) {
					this.newSection = 0
				}
			}
		}
	})
</script>