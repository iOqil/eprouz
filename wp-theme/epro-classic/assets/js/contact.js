/**
 * Contact form AJAX submission (vanilla JS, no dependencies).
 *
 * @package epro-classic
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var form = document.getElementById('epro-contact-form');
		if (!form) {
			return;
		}

		form.addEventListener('submit', function (event) {
			event.preventDefault();

			var btn = form.querySelector('[type=submit]');
			var savedHtml = btn ? btn.innerHTML : '';

			if (btn) {
				btn.disabled = true;
				btn.textContent = 'Yuborilmoqda...';
			}

			var fd = new FormData(form);
			fd.append('action', 'epro_contact');

			fetch(eproContact.ajaxUrl, {
				method: 'POST',
				body: fd,
				credentials: 'same-origin'
			})
				.then(function (r) {
					return r.json();
				})
				.then(function (res) {
					var s = document.getElementById('epro-contact-status');
					if (!s) {
						return;
					}
					s.classList.remove('hidden', 'text-green-600', 'text-red-600');
					if (res && res.success) {
						s.classList.add('text-green-600');
						s.textContent = form.dataset.successTitle + ' ' + form.dataset.successBody;
						form.reset();
					} else {
						s.classList.add('text-red-600');
						s.textContent = form.dataset.errorTitle + ' ' + form.dataset.errorBody;
					}
				})
				.catch(function () {
					var s = document.getElementById('epro-contact-status');
					if (!s) {
						return;
					}
					s.classList.remove('hidden');
					s.classList.add('text-red-600');
					s.textContent = form.dataset.errorTitle + ' ' + form.dataset.errorBody;
				})
				.finally(function () {
					if (btn) {
						btn.disabled = false;
						btn.innerHTML = savedHtml;
					}
				});
		});
	});
})();
