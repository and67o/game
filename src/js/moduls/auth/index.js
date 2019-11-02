import {
	validateEmail,
	validatePassword
} from "../validate";
import {
	addError
} from '../utils';
import {
	getTemplate
} from "./tmp";

export function auth () {
	const modalContainer = $('.modal-container');
	if (!modalContainer.length) {
		$('.main-page').after(getTemplate());
		bindEventsAuth();
	} else {
		modalContainer.remove();
	}
}

function bindEventsAuth() {
	$('.js-close-modal').on('click', () => closeModal());
	$('.js-btn-submit').on('click', () => authorisation());
}

const validate = (email, password) => {
	const emailError = validateEmail(email);
	const passwordError = validatePassword(password);
	if (emailError) {
		addError(emailError, '.js-error-email');
	}
	if (passwordError) {
		addError(passwordError, '.js-error-password');
	}
	if (!emailError && !passwordError) {
		return true;
	}
};

function authorisation() {
	const email = $('.js-auth-email').val();
	const password = $('.js-auth-password').val();
	const error = validate();
	if (error) {
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

