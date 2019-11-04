import {
	haveRepeatValue
} from "../../moduls/validate";

export const validateField = (number, countOfNumber) => {
	let error = '';
	if (!number) {
		error = 'Ввведите число';
	} else if (number.length !== countOfNumber || number.length > countOfNumber) {
		error = 'Ввведите ' + countOfNumber + '-х значное число';
	} else if (haveRepeatValue(number)) {
		error = 'Одинаковые числа';
	} else if (!(getAllValue().indexOf(number) === -1)) {
		error = 'Вы уже называли такое число';
	}
	return error;
};

const getAllValue = () => {
	let allValue = [];
	document.querySelectorAll('p[data-number]').forEach(function(element) {
		allValue.push(element.dataset.number);
	});
	return allValue;
};
