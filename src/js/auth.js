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
		// if (!emailError) {
		// 	this.addError(emailError);
		// }
		// if (!passwordError) {
		// 	this.addError(passwordError);
		// }
		console.log(334);
		const dataForAjax = {
			url: 'auth/authorisation',
			type: 'POST',
			dataType: 'json',
			data: {
			
			}
		};
		$.ajax(dataForAjax)
			.done((response) => {
				console.log(response);
			}).fail(() => {
				// location.reload();
			});
		
		
		
	}
	
	addError(error) {
	
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
