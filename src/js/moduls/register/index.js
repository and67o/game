import {
	getTemplate
} from "./tmp";
import Modal from "../modal";
import {
	registerNewPerson
} from "./register";

export function register () {
	const modalContainer = $('.modal-container');
	if (!modalContainer.length) {
		new Modal({
			headerName: 'Регистрация',
			content: getTemplate(),
			needBtnClose: true,
			callbacks: {
				btnSubmit: () => {
					registerNewPerson();
				}
			},
		}).init();
	} else {
		modalContainer.remove();
	}
}
