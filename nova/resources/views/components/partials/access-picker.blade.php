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
				<div class="radio">
					<label><input type="radio" name="access_type" v-model="accessType" value="roles-loose" @change="updateAccessType('roles-loose')"> Restrict by any of the selected roles</label>
				</div>
				<div class="radio">
					<label><input type="radio" name="access_type" v-model="accessType" value="roles-strict" @change="updateAccessType('roles-strict')"> Restrict by all of the selected roles</label>
				</div>
				<div class="radio">
					<label><input type="radio" name="access_type" v-model="accessType" value="permissions-loose" @change="updateAccessType('permissions-loose')"> Restrict by any of the selected permissions</label>
				</div>
				<div class="radio">
					<label><input type="radio" name="access_type" v-model="accessType" value="permissions-strict" @change="updateAccessType('permissions-strict')"> Restrict by all of the selected permissions</label>
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

			<p class="text-sm text-muted" v-show="accessType == 'roles-strict'">This item will be shown if the user has <strong>all</strong> of the roles selected above.</p>
			<p class="text-sm text-muted" v-show="accessType == 'roles-loose'">This item will be shown if the user has <strong>any</strong> of the roles selected above.</p>
			<p class="text-sm text-muted" v-show="accessType == 'permissions-strict'">This item will be shown if the user has <strong>all</strong> of the permissions selected above.</p>
			<p class="text-sm text-muted" v-show="accessType == 'permissions-loose'">This item will be shown if the user has <strong>any</strong> of the permissions selected above.</p>

			<input type="hidden" name="access" :value="accessItems">
		</div>
	</div>
</template>