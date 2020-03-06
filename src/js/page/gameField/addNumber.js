import {
	validateField
} from "./validate";
import {
	addError
} from "../../moduls/utils";
import * as axios from "axios";
import Modal from "../../moduls/modal";

const goodRequest = (response, number) => {
	if (response) {
		if (response.youWin) {
			new Modal({
				headerName: 'Поздравляю',
				content: `Ты угадал`,
				modalClass: 'modal-notice',
				needBtnClose: true,
			}).init();
		} else {
			const {
				data: {
					rightPosition,
					rightCount
				}
			} = response;
			const result = hangleResult(rightCount, rightPosition);
			$('.game__fields').append(getNewNumberLineHTML(number, result));
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

export const addNewNumber = (countOfNumber) => {
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
		url: '/GameField/addNewNumber',
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
			(response) => goodRequest(response.data, $number.val())
		)
		.catch((error) => {
			console.log(error)
			// location.reload();
		});
};
