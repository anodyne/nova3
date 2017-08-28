<template>
	<div :class="containerClasses" v-cloak>
		<div class="avatar-image">
			<a :href="profileLink" :class="classes" :style="'background-image:url(' + url + ')'" v-if="type == 'link'"></a>
			<div :class="classes" :style="'background-image:url(' + url + ')'" v-if="type == 'image'"></div>
			<span :class="statusClasses"
				  :title="statusTooltip"
				  data-toggle="tooltip"
				  v-if="showStatus"></span>
		</div>

		<div v-if="showContent">
			<div class="avatar-label" v-if="size == 'lg'" v-cloak>
				<span class="h1" v-if="showName">{{ this.displayName }}</span>
				<span class="text-muted" v-if="showMetadata" v-text="positionName"></span>
			</div>

			<div class="avatar-label" v-if="size == 'md'" v-cloak>
				<span class="avatar-title" v-if="showName" v-text="displayName"></span>
				<span class="avatar-meta" v-if="showMetadata" v-text="positionName"></span>
			</div>

			<div class="avatar-label" v-if="size == 'sm'">
				<span class="avatar-title" v-if="showName" v-text="displayName"></span>
				<span class="avatar-meta" v-if="showMetadata" v-text="positionName"></span>
			</div>

			<div class="avatar-label" v-if="size == 'xs'">
				<span class="avatar-title" v-if="showName" v-text="displayName"></span>
				<span class="avatar-meta" v-if="showMetadata" v-text="positionName"></span>
			</div>

			<div class="avatar-label" v-if="size == ''" v-cloak>
				<span class="h6 mb-1" v-if="showName">{{ this.displayName }}</span>
				<small class="text-muted" v-if="showMetadata" v-text="positionName"></small>
			</div>
		</div>
	</div>
</template>

<script>
	import md5 from 'md5';

	export default {
		props: {
			character: { type: Object, required: true },
			showContent: { type: Boolean, default: true },
			showName: { type: Boolean, default: true },
			showMetadata: { type: Boolean, default: true },
			showStatus: { type: Boolean, default: false },
			size: { type: String, default: '' },
			type: { type: String, default: 'link' },
			layout: { type: String, default: 'spread' },
			position: { type: Object }
		},

		computed: {
			classes () {
				return ['avatar', this.size];
			},

			containerClasses () {
				return [
					'avatar-container',
					'avatar-' + this.layout,
					'avatar-' + this.size
				];
			},

			displayName () {
				let pieces = [];

				if (this.character.rank != null) {
					pieces.push(this.character.rank.info.name);
				}

				pieces.push(this.character.name);

				return pieces.join(' ');
			},

			positionName () {
				if (this.position) {
					return this.position.name;
				}

				if (this.character.primaryPosition) {
					return this.character.primaryPosition.name;
				}

				return null;
			},

			profileLink () {
				return route('characters.bio', {character:this.character.id});
			},

			statusClasses () {
				let classes = ['avatar-status'];

				if (this.character.user && !this.character.isPrimaryCharacter) {
					classes.push('secondary');
				}

				if (this.character.user && this.character.isPrimaryCharacter) {
					classes.push('primary');
				}

				return classes;
			},

			statusTooltip () {
				if (window.Nova.user == null) {
					return '';
				}

				if (this.character.user) {
					if (this.character.isPrimaryCharacter) {
						return this._m('characters-primary-of', {2:this.character.user.displayName});
					} else {
						return this._m('characters-pnpc-of', {2:this.character.user.displayName});
					}
				}

				return this._m('characters-npc');
			},

			url () {
				return this.character.avatarImage;
			}
		},

		methods: {
			_m (key, variables = '') {
				return window._m(key, variables);
			}
		}
	};
</script>