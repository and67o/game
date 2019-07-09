import './../scss/base.scss';
import './../scss/gameField.scss';

class check {
	constructor() {
		this.computerNumber = 3451;
		this.countOfNumber = 4;
	}

	addNewNumber() {
		const $errorField = document.querySelector('.error-field');
		$errorField.innerText = '';
		const $number = $('.js-input-number');
		const error = this.validateField($number.val());
		console.log(error);
		if (error) {
			this.showError(error);
			return;
		}
		const dataForAfax = {
			url: 'GameField/addNewNumber',
			type: 'POST',
			dataType: 'json',
			data: {
				number: $number.val()
			}
		};
		$.ajax(dataForAfax)
			.done((response) => this.goodRequest(response, $number.val()))
			// .fail(this.badRequest());
	}

	goodRequest(response, number) {
		const {
			rightPosition,
			rightCount
		} = response;
		const result  = this.hangleResult(rightCount, rightPosition);
		$('.game__fields').append(this.getNewNumberLineHTML(number, result));
	};

	badRequest = () => {
		// location.reload();
	};

	/**
	 * Формирует строку с информацией о ходе пользователя
	 * @param number
	 * @param result
	 * @returns {string}
	 */
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

	showError = (error) => {
		const $errorField = document.querySelector('.error-field');
		$errorField.innerText = error;
	};

	bindEvents() {
		const $btnAddNewNumber = $('.js-btn-go');
		$btnAddNewNumber.on('click', () => this.addNewNumber());
	}

	init() {
		this.bindEvents();
	}
}

const jofh = new check();
jofh.init();