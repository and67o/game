import './../scss/base.scss';
import './../scss/mainPage.scss';
import {
	fireAsync,
} from './moduls/utils';
import {
	auth,
	logOut
} from "./moduls/auth";
import {
	register
} from "./moduls/register";

const bindEvents = () => {
	const
		logInBtn = $('.js-log-in'),
		registerBtn = $('.js-register'),
		logOutBtn = $('.js-log-out');

	if (Boolean(logInBtn)) {
		logInBtn.on('click', () => auth());
	}
	if (Boolean(registerBtn)) {
		registerBtn.on('click', () => register());
	}
	if (Boolean(logOutBtn)) {
		logOutBtn.on('click', () => logOut());
	}
};

const init = () => fireAsync([
		bindEvents,
	]
);

document.addEventListener('DOMContentLoaded', init);
