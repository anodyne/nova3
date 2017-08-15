<template>
	<div class="avatar-container" v-cloak>
		<a :href="profileLink" :class="classes" :style="'background-image:url(' + url + ')'" v-if="type == 'link'"></a>
		<div :class="classes" :style="'background-image:url(' + url + ')'" v-if="type == 'image'"></div>

		<div v-if="hasContent">
			<div class="avatar-label ml-3" v-if="size == 'lg'" v-cloak>
				<span class="h1" v-if="showName">{{ this.displayName }}</span>
				<span class="text-muted" v-if="showMetadata">{{ this.character.position.name }}</span>
			</div>

			<div class="avatar-label ml-3" v-if="size == 'md'" v-cloak>
				<span class="h4" v-if="showName">{{ this.displayName }}</span>
				<span class="text-muted" v-if="showMetadata">{{ this.character.position.name }}</span>
			</div>

			<div class="avatar-label ml-2" v-if="size == 'sm'">
				<span class="h5 mb-0" v-if="showName">{{ this.displayName }}</span>
			</div>

			<div class="avatar-label ml-2" v-if="size == 'xs'">
				<span class="h6 mb-0" v-if="showName">{{ this.displayName }}</span>
			</div>

			<div class="avatar-label ml-3" v-if="size == ''" v-cloak>
				<span class="h6 mb-1" v-if="showName">{{ this.displayName }}</span>
				<small class="text-muted" v-if="showMetadata">
					{{ this.character.position.name }}
				</small>
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

			profileLink () {
				return '/character/' + this.character.id;
			},

			url () {
				return this.character.avatarImage;
			}
		}
	};
</script>