import './../scss/base.scss';
import {
	validateEmail,
	validatePassword
} from './moduls/validate.js'
import {
	fireAsync,
} from './moduls/utils';

export class Auth {
	constructor() {
		this.init();
	}

	bindEvents() {
		$('.js-log-in').on('click', () => this.showModal());
		$('.js-log-out').on('click', () => this.logOut());
	}

	bindEventsAuth() {
		$('.js-close-modal').on('click', () => this.closeModal());
		$('.js-btn-submit').on('click', () => this.authorisation());
	}
	logOut = () => {
		console.log(222);
		document.cookie ='userId=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
		location.reload();
	};

	closeModal = () => {
		$('.modal-container').remove();
	};

	showModal() {
		const modalContainer = $('.modal-container');
		if (!modalContainer.length) {
			$('.main-page').after(this._modalAuth());
			this.bindEventsAuth();
		} else {
			modalContainer.remove();
		}
	}
	
	_modalAuth = () => {
		return `
			<div class="modal-container ">
				<div class="modal">
					<div class="modal__header">
						<p class="modal__title">Слова</p>
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
						location.reload()
					}
				})
			// .fail(() => {
			// 	// location.reload();
			// });
		}
	}
	
	addError = (error, elem = 'error-field') => {
		document.querySelector(elem).innerHTML = error;
	};
	
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
