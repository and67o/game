import './../scss/base.scss';
import './../scss/auth.scss';
import {
	validateEmail,
	validatePassword
} from './moduls/validate.js'
import {
	fireAsync,
} from './moduls/utils';

class Auth {
	constructor() {
		this.btnSubmit = $('.js-btn-auth');
		this.init();
	}
	
	bindEvents() {
		this.btnSubmit.on('click', () => this.authorisation());
	}
	
	authorisation() {
		const email = $('.js-auth-email').val();
		const password = $('.js-auth-password').val();
		const emailError = validateEmail(email);
		const passwordError = validatePassword(password);
		if (emailError) {
			this.addError(emailError, '.js-error-email');
		}
		if (passwordError) {
			this.addError(passwordError, '.js-error-password');
		}
		if (!emailError && !passwordError) {
			const dataForAjax = {
				url: 'auth/authorisation',
				type: 'POST',
				dataType: 'json',
				data: {
					email: email,
					password: password
				}
			};
			$.ajax(dataForAjax)
				.done((response) => {
					console.log(response);
					if (response.result) {
					
					}
				})
			// .fail(() => {
			// 	// location.reload();
			// });
		}
	}
	
	addError(error, elem = 'error-field') {
		document.querySelector(elem).innerHTML = error;
	}
	
	init() {
		this.bindEvents();
	}
}

const authLogin = () => new Auth();

const init = () =>
	fireAsync([
		authLogin,
	]);

document.addEventListener('DOMContentLoaded', init);
