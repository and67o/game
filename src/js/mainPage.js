import './../scss/base.scss';
import './../scss/mainPage.scss';
import { Auth } from "./../js/auth";

class MainPage {
	constructor() {
		this.init();
	}
	
	init() {
		Auth();
	}
}
