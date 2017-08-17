<template>
	<div class="avatar-container" v-cloak>
		<div class="avatar-image">
			<a :href="profileLink" :class="classes" :style="'background-image:url(' + url + ')'" v-if="type == 'link'"></a>
			<div :class="classes" :style="'background-image:url(' + url + ')'" v-if="type == 'image'"></div>
			<span :class="statusClasses"
				  :title="statusTooltip"
				  data-toggle="tooltip"
				  v-if="showStatus"></span>
		</div>

		<div v-if="hasContent">
			<div class="avatar-label ml-3" v-if="size == 'lg'" v-cloak>
				<span class="h1" v-if="showName">{{ this.displayName }}</span>
				<span class="text-muted" v-if="showMetadata" v-text="positionName"></span>
			</div>

			<div class="avatar-label ml-3" v-if="size == 'md'" v-cloak>
				<span class="h4" v-if="showName">{{ this.displayName }}</span>
				<span class="text-muted" v-if="showMetadata" v-text="positionName"></span>
			</div>

			<div class="avatar-label ml-2" v-if="size == 'sm'">
				<span class="h5 mb-0" v-if="showName">{{ this.displayName }}</span>
			</div>

			<div class="avatar-label ml-2" v-if="size == 'xs'">
				<span class="h6 mb-0" v-if="showName">{{ this.displayName }}</span>
			</div>

			<div class="avatar-label ml-3" v-if="size == ''" v-cloak>
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
			hasContent: { type: Boolean, default: true },
			showName: { type: Boolean, default: true },
			showMetadata: { type: Boolean, default: true },
			showStatus: { type: Boolean, default: false },
			size: { type: String, default: '' },
			type: { type: String, default: 'link' }
		},

		computed: {
			classes () {
				return ['avatar', this.size];
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
				if (this.character.primaryPosition) {
					return this.character.primaryPosition.name
				}

				return null
			},

			profileLink () {
				return '/character/' + this.character.id;
			},

			statusClasses () {
				let classes = ['status']

				if (this.character.user && !this.character.isPrimaryCharacter) {
					classes.push('secondary')
				}

				if (this.character.user && this.character.isPrimaryCharacter) {
					classes.push('primary')
				}

				return classes
			},

			statusTooltip () {
				if (window.Nova.user == null) {
					return ''
				}

				if (this.character.user) {
					if (this.character.isPrimaryCharacter) {
						return 'Primary character of ' + this.character.user.displayName
					} else {
						return 'PNPC of ' + this.character.user.displayName
					}
				}

				return 'NPC'
			},

			url () {
				return this.character.avatarImage;
			}
		}
	};
</script>