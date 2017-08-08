<template>
	<div class="form-group">
		<div v-show="!uploadedFile">
			<div v-if="allowMultiple || (!allowMultiple && files.length == 0)">
				<label for="file-upload" class="btn btn-secondary" v-html="showIcon('add')"></label>
				<input type="file" id="file-upload" name="file" class="hidden" @change="processFile">
			</div>

			<div class="row mt-3">
				<div class="col-sm-6 col-lg-3" v-for="file in files">
					<div class="card">
						<img class="card-img-top" :src="getFile(file)">
						<div class="card-footer d-flex justify-content-between">
							<div>
								<span v-if="allowMultiple">
									<a href="#"
									   class="card-link mr-2"
									   v-if="!isPrimary(file)"
									   @click.prevent="makePrimary"
									   v-html="showIcon('star')"></a>
									<span class="card-link text-warning mr-2"
										  v-if="isPrimary(file)"
										  v-html="showIcon('star')"></span>
								</span>
								<a href="#"
								   class="card-link text-danger"
								   @click.prevent="removeFile"
								   v-html="showIcon('delete')"></a>
							</div>
							<div v-if="allowMultiple">
								<div class="card-link text-subtle" v-html="showIcon('bars')"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div v-show="uploadedFile">
			<div id="cropper"></div>

			<div class="d-flex justify-content-around">
				<span>
					<button class="btn btn-success"
							@click.prevent="saveFile"
							v-html="showIcon('upload')"></button>
					<button class="btn btn-secondary ml-2"
							@click.prevent="reset"
							v-html="showIcon('close')"></button>
				</span>
			</div>
		</div>
	</div>
</template>

<script>
	import pluralize from 'pluralize'

	export default {
		props: {
			allowMultiple: { type: Boolean, default: true },
			item: { type: Object, required: true },
			type: { type: String, required: true }
		},

		data () {
			return {
				crop: {},
				files: this.item.media,
				uploadedFile: '',
			}
		},

		methods: {
			createCropper () {
				this.crop = $('#cropper').croppie({
					boundary: {
						width: Math.min(600, window.innerWidth - 10),
						height: Math.min(600, window.innerHeight - 10)
					},
					viewport: {
						width: Math.min(500, window.innerWidth - 10),
						height: Math.min(500, window.innerHeight - 10)
					}
				})
			},

			createFile (file) {
				let reader = new FileReader()
				let self = this

				reader.onload = (event) => {
					self.uploadedFile = event.target.result

					self.crop.croppie('bind', {
						url: self.uploadedFile
					})
				}

				reader.readAsDataURL(file)
			},

			isPrimary (file) {
				return file.primary === 1
			},

			processFile (event) {
				let files = event.target.files || event.dataTransfer.files

				if (! files.length) {
					return
				}

				this.createFile(files[0])
			},

			getFile (file) {
				return [
					window.Nova.baseUrl,
					'storage',
					'app',
					'public',
					pluralize(this.type),
					file.filename
				].join('/')
			},

			reset () {
				document.getElementById('file-upload').value = ''
				this.image = ''
			},

			saveFile () {
				let self = this

				this.crop.croppie('result', 'canvas').then(function (canvas) {
					axios.post(route('media.store'), {
						image: canvas,
						location: pluralize(self.type),
						id: self.item.id,
						type: self.type
					}).then(function (response) {
						flash('Media saved', 'File saved', 'success')
					})
				})

				this.reset()
			},

			showIcon (icon) {
				return window.icon(icon)
			}
		},

		mounted () {
			this.createCropper()
		}
	}
</script>