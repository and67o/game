import Modal from "../modal";
import {
	email,
	password,
	name
} from "../modal-auth-register";

export const getTemplate = () => {

	const content = () => {
		return `
			${name()}
			${email()}
			${password()}
		`;
	};

	const modal = new Modal(
		{
			headerName: 'Регистрация',
			content: content(),
			needBtnClose: true
		}
	);
	return modal.init();
};
