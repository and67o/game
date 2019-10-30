import {fireAsync} from "../utils";

class Modal {
    constructor({headerName, content, needBtnClose}) {
        this.modalParams = {
            headerName: headerName ? headerName : '',
            content: content ? content : '',
            needBtnClose: Boolean(needBtnClose)
        };
        this.init();
    }

    init() {
        const html = `
            <div class="modal-container ">
                <div class="modal">
                    <div class="modal__header">
                        <p class="modal__title">${this.modalParams.headerName}</p>
                        ${this.modalParams.needBtnClose ?
                            `<button class="btn btn-close js-close-modal">X</button>` : ``
                        }
                    </div>

                    <div class="modal__content">
                        ${this.modalParams.content}
                    </div>

                    <div class="modal__footer">
                        <button class="btn js-btn-submit">Ок</button>
                    </div>
                </div>
                <div class="modal__mask"></div>
            </div>
        `;
        return html;
    }
}

export default Modal;