import {
	preparedParams
} from './utils';
import isFunction from 'lodash-es/isFunction';

class Modal {
	constructor(params) {
		this.modalParams = preparedParams(params);
	}
	
	init() {
		$('#content').after(this.getTemplate());
		this.bindEvents();
	}

	bindEvents() {
		this.closeModal();
		this.submitModal();
		this.onOpen();
	};

	closeModal = () => {
		$('.js-close-modal').on('click', () => {
			if (isFunction(this.modalParams.callbacks.btnClose)) {
				this.modalParams.callbacks.btnClose()
			} else {
				$('.modal-container').remove();
			}
		})
	};
	
	onOpen = () => {
		if (isFunction(this.modalParams.callbacks.onOpen)) {
			this.modalParams.callbacks.onOpen()
		} else {
			$('.modal-container').remove();
		}
	};
	
	submitModal = () => {
		$('.js-btn-submit').on('click', () => {
			if (isFunction(this.modalParams.callbacks.btnSubmit)) {
				this.modalParams.callbacks.btnSubmit()
			} else {
				$('.modal-container').remove();
			}
		});
	};

	getTemplate() {
		const {
			modalClass,
			needBtnClose,
			headerName,
			content
		} = this.modalParams;
		return `
			<div class="modal-container ">
				<div class="modal ${modalClass ? modalClass : ''}">
					<div class="modal__header">
						<p class="modal__title">${headerName}</p>
						${needBtnClose ? `<button class="btn btn-close js-close-modal">X</button>` : ``}
					</div>

					<div class="modal__content">
					    ${content}
					</div>

					<div class="modal__footer">
						<button class="btn js-btn-submit">Ок</button>
					</div>
				</div>
				<div class="modal__mask"></div>
			</div>
		`;
	}
}

export default Modal;
