vue = {
	data: {
		password: "",
		passwordConfirmation: ""
	},

	methods: {
		generatePassword: function () {
			var s = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-!@#$%^&*=+~,.?|"

			var newPassword = Array(12).join().split(',').map(function () {
				return s.charAt(Math.floor(Math.random() * s.length))
			}).join('')

			this.password = newPassword
			this.passwordConfirmation = newPassword
		},

		resetPassword: function () {
			//
		}
	}
}