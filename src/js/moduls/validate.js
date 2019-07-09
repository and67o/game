const MIN_LENGTH = 3;

export const validateEmail = (email) => {
	let error = '';
	if (!email.length) {
		error = 'Введите email';
	} else if (minLength(email)) {
		error = 'Слишком мало символов';
	}
	return error;
};

function minLength(email, minLen = MIN_LENGTH) {
	return email.length < minLen;
}

export const validatePassword = (password) => {
	let error = '';
	return error;
}
