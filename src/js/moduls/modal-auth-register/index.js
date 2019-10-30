import Modal from "../modal";

const email = () => {
    return `
        <div class="auth__email">
            <p class="auth__text">Email</p>
            <input class="auth__field js-auth-email" type="text" placeholder="Email" value="">
            <p class="error-field js-error-email"></p>
        </div>
    `;
};

const name = () => {
    return ``;
};

const header = (title) => {
    return `
        <div class="modal__header">
            <p class="modal__title">${title}</p>
            <button class="btn btn-close js-close-modal">X</button>
        </div>
    `;
};

const password = () => {
    return `
        <div class="auth__password">
            <p class="auth__text">Пароль</p>
            <input class="auth__field js-auth-password" type="password" placeholder="Пароль" value="">
            <p class="error-field js-error-password"></p>
        </div>
    `;
};

const btnSubmit = () => {
    return `
        <button class="btn js-btn-submit">Ок</button>
    `
};

const content = () => {
    return `
        ${email()}
        ${password()}
    `;
};
const modalAuth = (title) => {
    const modal = new Modal(
    {
        headerName: title,
        content: content(),
        needBtnClose: true
    });
    return modal.init();
};

export default modalAuth;