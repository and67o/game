import * as EmailValidator from 'email-validator';
import {
	MAX_LENGTH,
	MIN_LENGTH
} from "./const";

const minLength = (email, minLen = MIN_LENGTH) => {
	return email.length < minLen;
};

const maxLength = (email, maxlength = MAX_LENGTH) => {
	return email.length < maxlength;
};

const isEmailCorrect = (email) => {
	return EmailValidator.validate(email);
};

export const validatePassword = (password) => {
	let error = '';
	if (!password.length) {
		error = 'Введите пароль';
	} else if (minLength(password)) {
		error = 'Слишком мало символов';
	}
	return error;
};

export const validateEmail = (email) => {
	let error = '';
	if (!email.length) {
		error = 'Введите email';
	} else if (minLength(email)) {
		error = 'Слишком мало символов';
	} else if (maxLength(email)) {
		error = 'Слишком много символов';
	} else if (isEmailCorrect(email)) {
		error = 'Email набран некорректно';
	}
	return error;
};
