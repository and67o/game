import {
	email,
	password,
	defaultError
} from "../modal-auth-register";
import {
	socialBtn
} from "../social/btns";

export const getTemplate = () => {
	return `
		${email()}
		${password()}
		${defaultError()}
		${socialBtn()}
	`;
};
