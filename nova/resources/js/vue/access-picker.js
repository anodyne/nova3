Vue.component('access-picker', {
	template: "#access-picker-template",

	props: {
		type: "",
		permissions: [],
		roles: [],
		chosen: []
	},

	data: function () {
		return {
			accessType: "",
			config: {},
			items: [],
			query: "",
			selected: {}
		}
	},

	computed: {
		accessItems: function () {
			return JSON.stringify(this.items)
		}
	},

	methods: {
		removeSelectedItem: function (row) {
			this.items.$remove(row)
		},

		reset: function () {
			this.query = ""
			$('.typeaheadInput').typeahead('val', '')
		},

		updateAccessType: function (value) {
			if (value != "") {
				this.accessType = value

				// Destroy the existing instance of Typeahead
				$('.typeaheadInput').typeahead('destroy')

				// Do some data resets
				this.items = []
				this.query = ""

				var name, localStore, store

				if (value == "roles-strict" || value == "roles-loose") {
					name = "nova-roles"
					localStore = this.roles
				}

				if (value == "permissions-strict" || value == "permissions-loose") {
					name = "nova-permissions"
					localStore = this.permissions
				}

				store = new Bloodhound({
					datumTokenizer: Bloodhound.tokenizers.obj.whitespace('key', 'name'),
					queryTokenizer: Bloodhound.tokenizers.whitespace,
					local: localStore
				})

				$('.typeaheadInput').typeahead({
					highlight: true,
					hint: false
				}, {
					name: name,
					source: store,
					display: "name"
				})
			}
		}
	},

	ready: function () {
		this.updateAccessType(this.type)
		
		this.items = JSON.parse(this.chosen)

		var cvm = this

		$('.typeaheadInput').bind('typeahead:select', function (ev, suggestion) {
			cvm.selected = suggestion
			cvm.reset()
		})
	},

	watch: {
		"selected": function (newValue, oldValue) {
			if (newValue != "" && newValue != oldValue) {
				var type = (newValue.protected !== undefined) ? 'permission' : 'role'

				this.items.push({ type: type, name: newValue.name, key: newValue.key })
			}
		}
	}
})