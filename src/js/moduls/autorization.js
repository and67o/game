import {
	validateEmail,
	validatePassword
} from "./validate";
import {
	addError
} from './utils';

export function auth () {
	const modalContainer = $('.modal-container');
	if (!modalContainer.length) {
		$('.main-page').after(_modalAuth());
		bindEventsAuth();
	} else {
		modalContainer.remove();
	}
}

function bindEventsAuth() {
	$('.js-close-modal').on('click', () => closeModal());
	$('.js-btn-submit').on('click', () => authorisation());
}

const _modalAuth = () => {
	return `
			<div class="modal-container ">
				<div class="modal">
					<div class="modal__header">
						<p class="modal__title">Авторизация</p>
						<button class="btn btn-close js-close-modal">X</button>
					</div>
					<div class="modal__content">
						<div class="auth__email">
							<p class="auth__text">Email</p>
							<input class="auth__field js-auth-email" type="text" placeholder="Email" value="">
							<p class="error-field js-error-email"></p>
						</div>
						<div class="auth__password">
							<p class="auth__text">Пароль</p>
							<input class="auth__field js-auth-password" type="password" placeholder="Пароль" value="">
							<p class="error-field js-error-password"></p>
						</div>
					</div>
					<div class="modal__footer">
						<button class="btn js-btn-submit">Ок</button>
					</div>
				</div>
				<div class="modal__mask"></div>
			</div>
		`;
};

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

