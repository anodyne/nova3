<template>
	<div :class="containerClasses" v-cloak>
		<div class="avatar-image">
			<a :class="imageClasses"
			   :href="link"
			   :style="'background-image:url(' + imageUrl + ')'"
			   v-if="type == 'link'">
			</a>

			<div :class="imageClasses"
				 :style="'background-image:url(' + imageUrl + ')'"
				 v-if="type == 'image'">
			</div>

			<span :class="statusClasses"
				  :title="statusTooltip"
				  data-toggle="tooltip"
				  v-if="showStatus">
			</span>
		</div>

		<div class="avatar-label" v-if="showContent">
			<span class="avatar-title" v-if="showName" v-text="displayName"></span>
			<span class="avatar-meta" v-if="showMetadata">
				<slot>{{ positionName }}</slot>
			</span>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			item: { type: Object, required: true },
			layout: { type: String, default: 'spread' },
			showContent: { type: Boolean, default: true },
			showName: { type: Boolean, default: true },
			showMetadata: { type: Boolean, default: true },
			showStatus: { type: Boolean, default: true },
			size: { type: String, default: '' },
			type: { type: String, default: 'link' }
		},

		computed: {
			containerClasses () {
				return [
					'avatar-container',
					'avatar-' + this.layout,
					'avatar-' + this.size
				];
			},

			displayName () {
				return this.item.displayName;
				
				let pieces = [];

				if (this.isCharacter && this.item.rank != null) {
					pieces.push(this.item.rank.info.name);
				}

				pieces.push(this.item.name);

				return pieces.join(' ');
			},

			imageClasses () {
				return ['avatar', this.size];
			},

			imageUrl () {
				return this.item.avatarImage;
			},

			isCharacter () {
				return _.has(this.item, 'rank_id');
			},

			isUser () {
				return _.has(this.item, 'primary_character');
			},

			link () {
				if (this.isUser) {
					return route('profile.show', { user: this.item.id });
				}

				return route('characters.bio', { character: this.item.id });
			},

			positionName () {
				if (this.isCharacter) {
					if (this.position) {
						return this.position.name;
					}

					if (this.item.primaryPosition) {
						return this.item.primaryPosition.name;
					}
				}

				return null;
			},

			statusClasses () {
				let classes = ['avatar-status'];

				// Character
				if (this.item.user_id !== undefined) {
					if (this.item.isPrimaryCharacter) {
						classes.push('primary');
					}

					if (this.item.isPrimaryCharacter) {
						classes.push('secondary');
					}

					if (this.item.status == 1) {
						classes.push('success');
					}

					if (this.item.status == 3) {
						classes.push('warning');
					}

					if (this.item.status == 4) {
						classes.push('danger');
					}
				}

				// User
				if (this.item.primary_character !== undefined) {
					if (this.item.status == 1) {
						classes.push('success');
					}

					if (this.item.status == 2) {
						classes.push('primary');
					}

					if (this.item.status == 3) {
						classes.push('warning');
					}

					if (this.item.status == 4) {
						classes.push('danger');
					}
				}

				return classes;
			},

			statusTooltip () {
				if (window.Nova.user == null) {
					return null;
				}

				if (this.isCharacter) {
					if (this.item.user) {
						if (this.item.isPrimaryCharacter) {
							return this._m('characters-primary-of', {2:this.item.user.displayName});
						} else {
							return this._m('characters-pnpc-of', {2:this.item.user.displayName});
						}
					}

					return this._m('characters-npc');
				}

				return null;
			}
		},

		methods: {
			_m (key, variables = '') {
				return window._m(key, variables);
			}
		}
	};
</script>