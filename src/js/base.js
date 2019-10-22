import './../scss/base.scss';
import './../scss/mainPage.scss';
import { Auth } from "./../js/auth";
import {
	fireAsync,
} from './moduls/utils';

const page = () => new Auth();

const init = () => fireAsync([
		page,
	]
);

document.addEventListener('DOMContentLoaded', init);
