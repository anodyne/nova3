Vue.component('access-picker', {
	template: "#access-picker-template",

	props: {
		options: undefined,
		permissions: [],
		roles: []
	},

	data: function () {
		return {
			accessTypeSelection: "",
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

		setConfig: function () {
			var cfg = {
				inputClasses: "form-control input-lg",
				inputPlaceholder: "Start typing to search for roles and/or permissions"
			}

			if (this.options === undefined) {
				this.config = cfg
			} else {
				this.config = _.defaults(this.options, cfg)
			}
		}
	},

	ready: function () {
		this.setConfig()

		var cvm = this

		$('.typeaheadInput').bind('typeahead:select', function(ev, suggestion) {
			cvm.selected = suggestion
			cvm.reset()
		})
	},

	watch: {
		"accessTypeSelection": function (newValue, oldValue) {
			if (newValue != "" && newValue != oldValue) {
				// Destroy the existing instance of Typeahead
				$('.typeaheadInput').typeahead('destroy')

				// Do some data resets
				this.items = []
				this.query = ""

				var name, localStore, store

				if (newValue == "roles") {
					name = "nova-roles"
					localStore = this.roles
				}

				if (newValue == "permissions") {
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
		},

		"selected": function (newValue, oldValue) {
			if (newValue != "" && newValue != oldValue) {
				var type = (newValue.protected !== undefined) ? 'permission' : 'role'

				this.items.push({ type: type, name: newValue.name, key: newValue.key })
			}
		}
	}
})