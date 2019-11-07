import {
	getTemplate
} from "./tmp";
import Modal from "../modal";
import {
	authorisation
} from "./auth";

export function auth() {
	const modalContainer = $('.modal-container');
	if (!modalContainer.length) {
		new Modal({
			headerName: 'Авторизация',
			content: getTemplate(),
			needBtnClose: true,
			callbacks: {
				btnSubmit: () => {
					authorisation();
				}
			},
		}).init();
	} else {
		modalContainer.remove();
	}
}

export const logOut = () => {
	document.cookie = 'userId=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
	location.reload();
};
