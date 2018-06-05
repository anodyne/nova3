<template>
	<div class="item-picker" v-on-clickaway="away">
		<div class="item-picker-selector">
			<div role="button"
				 class="item-picker-toggle"
				 v-if="selectedUser"
				 @click.prevent="show = !show">
				<div class="item-picker-selected">
					<avatar :item="selectedUser" :show-metadata="false" :show-status="false" size="sm" type="image"></avatar>
					<div class="ml-3" v-html="showIcon('more')"></div>
				</div>
				<input type="hidden" :name="fieldName" v-model="selectedUser.id">
			</div>
			<div role="button"
				 class="item-picker-toggle"
				 v-if="!selectedUser"
				 @click.prevent="show = !show">
				<div class="item-picker-selected">
					<span v-text="lang('users-none')"></span>
					<span class="ml-3" v-html="showIcon('more')"></span>
				</div>
			</div>

			<slot></slot>
		</div>

		<div v-show="show" class="items-menu">
			<div class="search-group">
				<span class="search-field">
					<div v-html="showIcon('search')"></div>
					<input type="text" :placeholder="lang('users-find')" v-model="search">
				</span>
				<a href="#"
				   class="clear-search ml-2"
				   @click.prevent="search = ''"
				   v-html="showIcon('close-alt')"></a>
			</div>

			<div class="items-menu-alert" v-show="filteredUsers.length == 0">
				<div class="alert alert-warning" v-text="lang('users-error-not-found')"></div>
			</div>

			<div class="items-menu-item"
				 v-if="selectedUser != false"
				 v-text="lang('users-none')"
				 @click.prevent="selectUser(false)"></div>

			<div class="items-menu-item" v-for="user in filteredUsers" @click.prevent="selectUser(user)">
				<avatar :item="user" :show-metadata="false" :show-status="false" size="sm" type="image"></avatar>
			</div>
		</div>
	</div>
</template>

<script>
	import Avatar from './Avatar.vue';
	import { mixin as clickaway } from 'vue-clickaway';

	export default {
		props: {
			fieldName: { type: String, default: 'user_id' },
			items: { type: Array },
			selected: { type: Object }
		},

		components: { Avatar },

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

				return this.users.filter((user) => {
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

			fetch () {
				let self = this;

				if (this.items) {
					this.users = this.items;
				} else {
					axios.get(route('api.users')).then((response) => {
						self.users = response.data;
					});
				}
			},

			lang (key, attributes = '') {
				return window.lang(key, attributes);
			},

			selectUser (user) {
				this.selectedUser = user;
				this.show = false;
				this.search = '';

				this.$events.$emit('user-picker-selected', this.selectedUser);
			},

			showIcon (icon) {
				return window.icon(icon);
			}
		},

		created () {
			let self = this;

			if (this.selected) {
				this.selectedUser = this.selected;
			}

			this.fetch();

			this.$events.$on('user-picker-refresh', () => {
				self.fetch();
			});

			this.$events.$on('user-picker-reset', () => {
				self.selectedUser = false;
			});
		}
	};
</script>
