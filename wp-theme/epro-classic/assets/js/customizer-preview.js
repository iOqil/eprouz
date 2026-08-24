/*
 * Customizer live preview.
 * Most fields use selective refresh (registered in PHP); this only handles the
 * core site title, which appears in the brand mark and the footer copyright.
 */
(function () {
	'use strict';
	if (!window.wp || !wp.customize) return;

	wp.customize('blogname', function (value) {
		value.bind(function (to) {
			document.querySelectorAll('.epro-brand-name, .epro-site-name').forEach(function (el) {
				el.textContent = to;
			});
			document.querySelectorAll('.epro-brand-mark').forEach(function (el) {
				el.textContent = (to || 'E').charAt(0).toUpperCase();
			});
		});
	});
})();
