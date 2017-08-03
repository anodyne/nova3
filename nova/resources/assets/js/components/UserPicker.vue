<template>
	<div class="item-picker" v-on-clickaway="away">
		<div role="button"
			 class="selected-toggle"
			 v-if="selectedUser"
			 @click.prevent="show = !show">
			<div class="selected-item">
				<user-avatar :user="selectedUser" :has-label="true" size="xs" type="image"></user-avatar>
				<i class="far fa-angle-down fa-fw ml-3"></i>
			</div>
			<input type="hidden" name="user_id" v-model="selectedUser.id">
		</div>
		<div role="button"
			 class="selected-toggle"
			 v-if="!selectedUser"
			 @click.prevent="show = !show">
			<div class="selected-item">
				<span>No user</span>
				<i class="far fa-angle-down fa-fw ml-3"></i>
			</div>
		</div>

		<div v-show="show" class="items-menu">
			<div class="search-group">
				<span class="search-field">
					<i class="far fa-search fa-fw"></i>
					<input type="text" placeholder="Find by name or email" v-model="search">
				</span>
				<a href="#"
				   class="clear-search"
				   @click.prevent="search = ''">
				   <i class="far fa-times-circle fa-fw ml-2"></i>
				</a>
			</div>

			<div class="items-menu-alert" v-show="filteredUsers.length == 0">
				<div class="alert alert-warning">No users found</div>
			</div>

			<div class="items-menu-item" v-if="selectedUser != false" @click.prevent="selectUser(false)">
				No user
			</div>

			<div class="items-menu-item" v-for="user in filteredUsers" @click.prevent="selectUser(user)">
				<user-avatar :user="user" :has-label="true" size="xs" type="image"></user-avatar>
			</div>
		</div>
	</div>
</template>

<script>
	import UserAvatar from './UserAvatar.vue';
	import { mixin as clickaway } from 'vue-clickaway';

	export default {
		props: {
			selected: {
				type: Object
			}
		},

		components: { UserAvatar },

		mixins: [ clickaway ],

		data () {
			return {
				users: [],
				search: '',
				selectedUser: false,
				show: false
			}
		},

		computed: {
			filteredUsers () {
				let self = this;

				return this.users.filter(function (user) {
					let searchRegex = new RegExp(self.search, 'i');

					return searchRegex.test(user.name)
						|| searchRegex.test(user.nickname)
						|| searchRegex.test(user.email);
				});
			}
		},

		methods: {
			away () {
				this.show = false;
			},

			selectUser (user) {
				this.selectedUser = user;
				this.show = false;
				this.search = '';
			}
		},

		created () {
			let self = this;

			if (this.selected) {
				this.selectedUser = this.selected;
			}

			axios.get(route('api.users')).then((response) => {
				self.users = response.data;
			});
		}
	}
</script>
