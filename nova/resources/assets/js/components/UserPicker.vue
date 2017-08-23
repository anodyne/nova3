<template>
	<div class="item-picker" v-on-clickaway="away">
		<div class="item-picker-selector">
			<div role="button"
				 class="item-picker-toggle"
				 v-if="selectedUser"
				 @click.prevent="show = !show">
				<div class="item-picker-selected">
					<user-avatar :user="selectedUser" :has-label="true" size="xs" type="image"></user-avatar>
					<div class="ml-3" v-html="showIcon('more')"></div>
				</div>
				<input type="hidden" name="user_id" v-model="selectedUser.id">
			</div>
			<div role="button"
				 class="item-picker-toggle"
				 v-if="!selectedUser"
				 @click.prevent="show = !show">
				<div class="item-picker-selected">
					<span v-text="_m('users-none')"></span>
					<span class="ml-3" v-html="showIcon('more')"></span>
				</div>
			</div>

			<slot></slot>
		</div>

		<div v-show="show" class="items-menu">
			<div class="search-group">
				<span class="search-field">
					<div v-html="showIcon('search')"></div>
					<input type="text" :placeholder="_m('users-find')" v-model="search">
				</span>
				<a href="#"
				   class="clear-search ml-2"
				   @click.prevent="search = ''"
				   v-html="showIcon('close-alt')"></a>
			</div>

			<div class="items-menu-alert" v-show="filteredUsers.length == 0">
				<div class="alert alert-warning" v-text="_m('users-error-not-found')"></div>
			</div>

			<div class="items-menu-item"
				 v-if="selectedUser != false"
				 v-text="_m('users-none')"
				 @click.prevent="selectUser(false)"></div>

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
			selected: { type: Object }
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
			_m (key, attributes = '') {
				return window._m(key, attributes)
			},

			away () {
				this.show = false;
			},

			selectUser (user) {
				this.selectedUser = user;
				this.show = false;
				this.search = '';
			},

			showIcon (icon) {
				return window.icon(icon)
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
