import {
	validateEmail,
	validatePassword
} from "../validate/validate";
import {
	addError
} from '../utils';
import modalAuth from '../modal-auth-register';

export function register () {
	const modalContainer = $('.modal-container');
	if (!modalContainer.length) {
		$('.main-page').after(modalAuth('Регистрация'));
		bindEventsAuth();
	} else {
		modalContainer.remove();
	}
}

function bindEventsAuth() {
	$('.js-close-modal').on('click', () => closeModal());
	$('.js-btn-submit').on('click', () => registerNewPerson());
}

function registerNewPerson() {
	const email = $('.js-register-email').val();
	const password = $('.js-register-password').val();
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
			url: 'register/register',
			type: 'POST',
			dataType: 'json',
			data: {
				email: email,
				password: password
			}
		};
		$.ajax(dataForAjax)
			.done((response) => {
				const {
					result,
					error
				} = response;
				if (error) {
					addError(error, '.js-error-email');
					return;
				}
				if (result) {
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

