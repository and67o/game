import {
	validateEmail,
	validatePassword
} from "../validate/validate";
import {
	addError
} from '../utils';
import modalAuth from '../modal-auth-register';

export function auth () {
	const modalContainer = $('.modal-container');
	if (!modalContainer.length) {
		$('.main-page').after(modalAuth('Авторизация'));
		bindEventsAuth();
	} else {
		modalContainer.remove();
	}
}

function bindEventsAuth() {
	$('.js-close-modal').on('click', () => closeModal());
	$('.js-btn-submit').on('click', () => authorisation());
}

function authorisation() {
	const email = $('.js-auth-email').val();
	const password = $('.js-auth-password').val();
	const emailError = validateEmail(email);
	const passwordError = validatePassword(password);
	if (emailError) {
		addError(emailError, '.js-error-email');
	}
	if (passwordError) {
		addError(passwordError, '.js-error-password');
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
					location.reload()
				}
			})
			.fail(() => {
				// location.reload();
			});
	}
}

const closeModal = () => {
	$('.modal-container').remove();
};

