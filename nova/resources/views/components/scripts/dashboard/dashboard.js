NovaVue = {
	data: {
		showInstallChecklist: true,
		showMigrateChecklist: true
	},

	methods: {
		finishInstallation () {
			axios.post(route('dashboard.finish-install'));

			this.showInstallChecklist = false;
		},

		finishMigration () {
			axios.post(route('dashboard.finish-migrate'));

			this.showMigrateChecklist = false;
		},

		sendTestEmail () {
			axios.post(route('dashboard.send-test-email'))
				.then(function (response) {
					$.alert({
						title: lang('dashboard-test-email-confirm-header'),
						content: lang('dashboard-test-email-confirm-message'),
						theme: "dark"
					});
				})
				.catch(function (error) {
					//
				});
		}
	}
}
