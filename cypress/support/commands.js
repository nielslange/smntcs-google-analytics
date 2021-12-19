// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************

Cypress.Commands.add("login", () => {
	cy.viewport(1200, 2000);
	cy.visit("http://localhost:8888/wp-login.php").wait(500);
	cy.get("#user_login").type("admin");
	cy.get("#user_pass").type("password");
	cy.get("#wp-submit").click();
});

Cypress.Commands.add("checkPluginActivation", () => {
	cy.viewport(1200, 2000);
	cy.visit("http://localhost:8888/wp-admin/plugins.php").wait(500);
	cy.get('tr[data-slug="smntcs-google-analytics"]').then(($link) => {
		if ($link.hasClass("inactive")) {
			cy.get('tr[data-slug="smntcs-google-analytics"] .activate a').click();
		}
	});
});

Cypress.Commands.add("checkPluginSettings", () => {
	cy.viewport(1200, 2000);
	cy.visit("http://localhost:8888/wp-admin/customize.php").wait(500);
	cy.get("#accordion-section-smntcs_google_analytics_section")
		.click()
		.wait(500);
	cy.get("#_customize-input-smntcs_google_analytics_tracking_code").clear();
	cy.get("#_customize-input-smntcs_google_analytics_tracking_code").type(`
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-XXXXX-Y', 'auto');
ga('send', 'pageview');
</script>
	`);
	cy.get("#save").click();
});

Cypress.Commands.add("checkGoogleAnalyticsCode", (selector) => {
	cy.viewport(1200, 2000);
	cy.visit("http://localhost:8888/").wait(500);
	cy.get(`
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-XXXXX-Y', 'auto');
ga('send', 'pageview');
</script>
	`);
});
