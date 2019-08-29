import './../scss/base.scss';
import './../scss/gameField.scss';
import {
	addError,
	fireAsync
} from './moduls/utils';

class GameField {
	constructor() {
		this.computerNumber = 3451;
		this.countOfNumber = 4;
		this.init();
	}

	addNewNumber() {
		const $errorField = document.querySelector('.error-field');
		$errorField.innerHTML = '';
		const $number = $('.js-input-number');
		const error = this.validateField($number.val());
		console.log(error);
		if (error) {
			addError(error, '.error-field');
			return;
		}
		const dataForAjax = {
			url: '/GameField/addNewNumber',
			type: 'POST',
			dataType: 'json',
			data: {
				number: $number.val()
			}
		};
		$.ajax(dataForAjax)
			.done((response) => this.goodRequest(response, $number.val()))
			.fail(this.badRequest());
	}

	goodRequest(response, number) {
		if (response) {
			const {
				rightPosition,
				rightCount
			} = response;
			const result  = this.hangleResult(rightCount, rightPosition);
			$('.game__fields').append(this.getNewNumberLineHTML(number, result));
		}
	};

	badRequest = () => {
		location.reload();
	};

	getNewNumberLineHTML = (number, result) => {
		return `
			<li class="game__fields__line">
				<p>${number}</p>
				<span class="line-field"></span>
				<p>${result}</p>
			</li>
		`;
	};

	hangleResult = (rightCount, rightPosition) =>  {
		return rightCount + 'x' + rightPosition;
	};

	validateField(number) {
		console.log(number);
		let error = '';
		if (!number) {
			error = 'Ввведите число';
		} else if (number.length !== this.countOfNumber) {
			error = 'Ввведите ' + this.countOfNumber + '-х значное число';
		}
		return error;
	}

	bindEvents() {
		const $btnAddNewNumber = $('.js-btn-go');
		$btnAddNewNumber.on('click', () => this.addNewNumber());
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
