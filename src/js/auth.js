import './../scss/base.scss';
import {
	auth
} from './moduls/autorization';
import {
	register
} from "./moduls/register";

export class Auth {
	constructor() {
		this.init();
	}

	bindEvents() {
		$('.js-log-in').on('click',() => {
			auth();
		});
		$('.js-register').on('click', () => {
			register()
		});
		$('.js-log-out').on('click', () => this.logOut());
	}

	logOut = () => {
		document.cookie ='userId=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
		location.reload();
	};

	init() {
		this.bindEvents();
	}
}
