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
				{ name: "id", value: "" },
				{ name: "class", value: "form-control input-lg" },
				{ name: "placeholder", value: "" }
			]
		},

		computed: {
			attrClass: function () {
				return find("attributes", "class").value
			},

			attrId: function () {
				return find("attributes", "id").value
			},

			attrPlaceholder: function () {
				return find("attributes", "placeholder").value
			},

			attrRows: function () {
				return find("attributes", "rows").value
			},

			fieldAttributes: function () {
				var arrList = []

				for (var i = 0; i < this.attributes.length; ++i) {
					var attribute = this.attributes[i]

					if (attribute.value != "")
						arrList[i] = attribute.name + "=\"" + attribute.value + "\""
				}

				return arrList.join(" ")
			}
		},

		methods: {
			addAttribute: function () {
				this.attributes.push({ name: "", value: "" })
			},

			addOption: function () {
				this.options.push({ text: "", value: "" })
			},

			removeAttribute: function (row) {
				this.attributes.$remove(row)
			},

			removeOption: function (row) {
				this.options.$remove(row)
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

				// Reset the attributes
				this.attributes = [
					{ name: "id", value: "" },
					{ name: "class", value: "form-control input-lg" },
					{ name: "placeholder", value: "" }
				]

				// Reset some other values
				this.fieldContainerClassSelect = "col-md-6"
				this.labelContainerClassSelect = "col-md-2"

				// Specific resets for text blocks
				if (value == "textarea")
				{
					this.fieldContainerClassSelect = "col-md-8"
					this.attributes.push({ name: "rows", value: "5" })
				}
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
</script>