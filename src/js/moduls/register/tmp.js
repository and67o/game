import {
	email,
	password,
	name
} from "../modal-auth-register";

export const getTemplate = () => {
	return `
		${name()}
		${email()}
		${password()}
	`;
};
