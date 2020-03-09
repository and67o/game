import '../../../scss/gameField.scss';
import {
	fireAsync
} from '../../moduls/utils';
import {
	addNewNumber,
	getGameId
} from "./addNumber";

class GameField {
	constructor() {
		this.countOfNumber = 4;
		this.gameId = getGameId();
		this.init();
	}

	bindEvents() {
		const $btnAddNewNumber = $('.js-btn-go');
		$btnAddNewNumber.on('click', () => addNewNumber(this.countOfNumber, this.gameId));
	}

	init() {
		this.bindEvents();
	}
}

const GameFieldClass = () => new GameField();

const init = () =>
	fireAsync([
		GameFieldClass,
	]);

document.addEventListener('DOMContentLoaded', init);
