import './../scss/base.scss';
import './../scss/mainPage.scss';
import { Auth } from "./moduls/base/auth";
import {
	fireAsync,
} from './moduls/utils';

const auth = () => new Auth();

const init = () => fireAsync([
		auth,
	]
);

document.addEventListener('DOMContentLoaded', init);
