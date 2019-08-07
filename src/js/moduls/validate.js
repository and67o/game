const MIN_LENGTH = 2;

export const validateEmail = (email) => {
	let error = '';
	if (!email.length) {
		error = 'Введите email';
	} else if (minLength(email)) {
		error = 'Слишком мало символов';
	}
	return error;
};

const minLength = (email, minLen = MIN_LENGTH) => {
	return email.length < minLen;
};

const isEmailCorrect = (email) => {

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
