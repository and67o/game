import Modal from "../modal";
import {
	email,
	password
} from "../modal-auth-register";

export const getTemplate = () => {
	
	const content = () => {
		return `
			${email()}
			${password()}
		`;
	};
	
	const modal = new Modal(
		{
			headerName: 'Авторизация',
			content: content(),
			needBtnClose: true
		});
	return modal.init();
};
