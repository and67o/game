import './../scss/base.scss';
import './../scss/mainPage.scss';
import { Auth } from "./../js/auth";
import {
	fireAsync,
} from './moduls/utils';

class MainPage {
	constructor() {
		this.init();
	}
	
	init() {
		 new Auth();
	}
}

const page = () => new MainPage();

const init = () =>
	fireAsync([
		page,
	]);

document.addEventListener('DOMContentLoaded', init);
