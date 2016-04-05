<p>Are you sure you want to remove the <strong>{{ $tab->present()->name }}</strong> tab from the <em>{{ $form->present()->name }}</em> form? This action is permanent and can't be undone!</p>

{!! Form::model($tab, ['route' => ['admin.forms.tabs.destroy', $form->key, $tab->id], 'method' => 'delete', 'id' => 'ajax']) !!}
	<div class="form-group">
		<div class="">
			<div class="checkbox">
				<label>
					{!! Form::checkbox('remove_tab_content', true, false, ['v-model' => 'removeTabContent']) !!}
					<strong>Delete All Tab Content?</strong>
				</label>
			</div>
		</div>
	</div>

	<div class="form-group" v-if="removeTabContent == false">
		<label class="control-label">New Tab</label>
		{!! Form::select('new_tab', $tabs, 0, ['class' => 'form-control input-lg', 'v-model' => 'newTab']) !!}
		<p class="help-block">Select the new tab that you want any sections and fields currently assigned to the {{ $tab->present()->name }} tab to be reassigned to.</p>
	</div>

	<div v-cloak>
		<phone-tablet>
			<p>{!! Form::button("Remove Form Tab", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
			<p>{!! Form::button("Cancel", ['class' => 'btn btn-default btn-lg btn-block', 'data-dismiss' => 'modal']) !!}</p>
		</phone-tablet>
		<desktop>
			{!! Form::button("Remove Form Tab", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}
			{!! Form::button("Cancel", ['class' => 'btn btn-link-default btn-lg', 'data-dismiss' => 'modal']) !!}
		</desktop>
	</div>
{!! Form::close() !!}

<script>
	new Vue({
		el: '#ajax',

		data: {
			newTab: 0,
			removeTabContent: false
		},

		watch: {
			removeTabContent: function (value, oldValue) {
				if (value == true) {
					this.newTab = 0
				}
			}
		}
	})
</script>