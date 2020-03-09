import {
	email,
	password,
	defaultError
} from "../modal-auth-register";

export const getTemplate = () => {
	return `
		${email()}
		${password()}
		${defaultError()}
	`;
};
