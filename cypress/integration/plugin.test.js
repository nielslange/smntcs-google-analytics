describe("Admin", () => {
	beforeEach(function () {
		cy.login();
	});

	it("can ensure the SMNTCS Google Analytics plugin is activated", () => {
		cy.checkPluginActivation();
	});

	it("can access plugin settings", () => {
		cy.checkPluginSettings();
	});

	it("can see Google Analytics code", () => {
		cy.checkGoogleAnalyticsCode();
	});
});
