import {
	validateField
} from "./validate";
import {
	addError
} from "../../moduls/utils";
import * as axios from "axios";
import Modal from "../../moduls/modal";

const goodRequest = ({
		data: {
			errors, result,
			data: {
				rightPosition, rightCount, youWin
			}
		}
	} = response, number) => {
	if (result) {
		if (youWin) {
			new Modal({
				headerName: 'Поздравляю',
				content: `Ты угадал`,
				modalClass: 'modal-notice',
				needBtnClose: true,
			}).init();
		} else {
			const resultHangle = hangleResult(rightCount, rightPosition);
			$('.game__fields').append(getNewNumberLineHTML(number, resultHangle));
		}
	}
};

const hangleResult = (rightCount, rightPosition) => {
	return rightCount + 'x' + rightPosition;
};

const getNewNumberLineHTML = (number, result) => {
	return `
		<li class="game__fields__line">
			<p data-number="${number}">${number}</p>
			<span class="line-field"></span>
			<p>${result}</p>
		</li>
	`;
};

export const addNewNumber = (countOfNumber, gameId) => {
	const
		$errorField = document.querySelector('.error-field'),
		$number = $('.js-input-number'),
		numberVal = $number.val(),
		error = validateField(numberVal, countOfNumber);
	
	$errorField.innerHTML = '';
	
	if (error) {
		addError(error, '.error-field');
		return;
	}
	
	const dataForAxios = {
		url: '/GameField/addNewNumber/' + gameId,
		data: {
			number: numberVal
		}
	};
	
	axios
		.post(
			dataForAxios.url,
			dataForAxios.data
		)
		.then(
			(response) => goodRequest(response, $number.val())
		)
		.catch((error) => {
			console.log(error)
		});
};

export function getGameId() {
	return window.location.pathname.split('/').pop()
}
