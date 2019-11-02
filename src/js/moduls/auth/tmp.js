import {
	email,
	password
} from "../modal-auth-register";

export const getTemplate = () => {
	return `
		${email()}
		${password()}
	`;
};
