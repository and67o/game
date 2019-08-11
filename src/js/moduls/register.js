import {
	validateEmail,
	validatePassword
} from "./validate";
import {
	addError
} from './utils';

export function register () {
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
	$('.js-btn-submit').on('click', () => registerNewPerson());
}

const _modalAuth = () => {
	return`
		<div class="modal-container ">
			<div class="modal">
				<div class="modal__header">
					<p class="modal__title">Регистрация</p>
					<button class="btn btn-close js-close-modal">X</button>
				</div>
				<div class="modal__content">
					<div class="auth__email">
						<label class="auth__text">Email</label>
						<input class="auth__field js-register-email" type="text" placeholder="Email" value="">
						<p class="error-field js-error-email"></p>
					</div>
					<div class="auth__password">
						<label class="auth__text">Пароль</label>
						<input class="auth__field js-register-password" type="password" placeholder="Пароль" value="">
						<p class="error-field js-error-password"></p>
					</div>
				</div>
				<div class="modal__footer">
					<button class="btn js-btn-submit btn-register">Зарегистрироваться</button>
				</div>
			</div>
			<div class="modal__mask"></div>
		</div>`
};

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

