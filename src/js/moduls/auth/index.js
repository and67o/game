import {
	getTemplate
} from "./tmp";
import Modal from "../modal";
import {
	authorisation
} from "./auth";
import * as axios from "axios";

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
	axios.post('/Auth/logOut');
};

