<access-picker
	:roles="roles"
	:permissions="permissions"
	type="{{ $type }}"
	chosen="{{ $selectedItems }}">
</access-picker>

<template id="access-picker-template">
	<div class="nova-access-picker-container">
		<div class="form-group">
			<div class="col-xs-12">
				<div class="radio-inline">
					<label><input type="radio" name="access_type" v-model="accessType" value="roles"> Restrict by Role(s)</label>
				</div>
				<div class="radio-inline">
					<label><input type="radio" name="access_type" v-model="accessType" value="permissions"> Restrict by Permission(s)</label>
				</div>
			</div>
		</div>

		<div class="nova-access-picker" v-show="accessType != ''">
			<input type="text" placeholder="Start typing to find roles and permissions" autocomplete="off" v-model="query" class="form-control input-lg typeaheadInput">

			<div class="selected-access-items">
				<span v-for="item in items">
					<span class="label label-default">
						@{{ item.type | capitalize }}: @{{ item.name }}
						<a class="remove" role="button" @click="removeSelectedItem(item)">&times;</a>
					</span>
				</span>
			</div>

			<input type="hidden" name="access" :value="accessItems">
		</div>
	</div>
</template>