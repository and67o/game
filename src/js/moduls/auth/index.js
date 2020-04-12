import {
	getTemplate
} from "./tmp";
import Modal from "../modal";
import {
	authorisation
} from "./auth";
import * as axios from "axios";
import {
	socialAuth
} from "../social";

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
				},
				onOpen: () => {
					$('.js-social-btn').on('click', (event) => socialAuth(event));
				}
			},
		}).init();
	} else {
		modalContainer.remove();
	}
}

export const logOut = () => {
	axios
		.post('/Auth/logOut')
		.then(() => {
			location.reload();
		})
		.catch(() => {
			location.reload();
		})
};

