{!! HTML::script('nova/resources/js/Sortable.min.js') !!}
<script>
	vue = {
		data: {
			fieldContainerClassSelect: "col-md-4",
			fieldContainerClass: "col-md-4",
			labelContainerClass: "col-md-2",
			labelContainerClassSelect: "col-md-2",
			label: "",
			type: "",
			options: [
				{ text: "", value: "" }
			],
			attributes: [
				{ name: "class", value: "form-control input-lg" },
				{ name: "placeholder", value: "" }
			],
			rules: [
				{ type: "", value: "", hasValue: false }
			],
			validationRules: "",
			hasValues: false
		},

		computed: {
			attrClass: function () {
				var obj = find("attributes", "class")

				if (obj)
					return obj.value

				return
			},

			attrPlaceholder: function () {
				var obj = find("attributes", "placeholder")

				if (obj)
					return obj.value

				return
			},

			attrRows: function () {
				var obj = find("attributes", "rows")

				if (obj)
					return obj.value

				return
			},

			hasType: function () {
				return this.type != ""
			}
		},

		methods: {
			addAttribute: function () {
				this.attributes.push({ name: "", value: "" })
			},

			addOption: function () {
				this.options.push({ text: "", value: "" })
			},

			addRule: function () {
				this.rules.push({ type: "", value: "", hasValue: false })
			},

			removeAttribute: function (row) {
				this.attributes.$remove(row)
			},

			removeOption: function (row) {
				this.options.$remove(row)
			},

			removeRule: function (row) {
				this.rules.$remove(row)
			},

			buildValidationRules: function() {
				var arrList = []

				for (var i = 0; i < this.rules.length; ++i) {
					var type = this.rules[i].type
					var value = this.rules[i].value

					var finalRule = type

					if (value != "")
						finalRule += ":" + value.replace(/ /g,'')

					arrList[i] = finalRule
				}

				this.validationRules = arrList.join('|')
			},

			updateRuleType: function (row) {
				switch (row.type) {
					case "between":
					case "exists":
					case "in":
					case "max":
					case "min":
					case "not_in":
						row.hasValue = true
						row.value = ""
					break

					default:
						row.hasValue = false
						row.value = ""
					break
				}

				this.buildValidationRules()
			},

			updateRuleValue: function (row) {
				this.buildValidationRules()
			}
		},

		watch: {
			"fieldContainerClassSelect": function (value, oldValue) {
				if (value != "Custom")
					this.fieldContainerClass = value
			},

			"labelContainerClassSelect": function (value, oldValue) {
				if (value != "Custom")
					this.labelContainerClass = value
			},

			"type": function (value, oldValue) {
				// Clear out the field values
				this.options = [
					{ text: "", value: "" }
				]

				// Clear out the validation rules
				this.rules = [
					{ type: "", value: "", hasValue: false }
				]

				// Reset the attributes
				this.attributes = [
					{ name: "class", value: "form-control input-lg" },
					{ name: "placeholder", value: "" }
				]

				// Reset some other values
				this.fieldContainerClassSelect = "col-md-6"
				this.labelContainerClassSelect = "col-md-2"
				this.hasValues = false

				// Specific resets for text blocks
				if (value == "textarea")
				{
					this.fieldContainerClassSelect = "col-md-8"
					this.attributes.push({ name: "rows", value: "5" })
				}

				if (value == "select" || value == "radio")
					this.hasValues = true
			}
		}
	}

	function find(item, name) {
		if ( ! vue.data[item]) return;

		var items = vue.data[item]

		for (var i = 0; i < items.length; ++i) {
			if (items[i].name === name)
				return items[i]
		}
	}

	Sortable.create(byId("sortable"), {
		handle: ".sortable-handle"
	})
</script>