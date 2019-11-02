import {
	validateEmail,
	validatePassword
} from "../validate";
import {
	addError
} from "../utils";

export const validate = (email, password) => {
	const emailError = validateEmail(email);
	const passwordError = validatePassword(password);
	if (emailError) {
		addError(emailError, '.js-error-email');
	}
	if (passwordError) {
		addError(passwordError, '.js-error-password');
	}
	if (!emailError && !passwordError) {
		return true;
	}
};
