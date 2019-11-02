export const email = () => {
    return `
        <div class="auth__email">
            <p class="auth__text">Email</p>
            <input class="auth__field js-auth-email" type="text" placeholder="Email" value="">
            <p class="error-field js-error-email"></p>
        </div>
    `;
};

export const name = () => {
    return `
        <div class="auth__name">
            <p class="auth__text">Имя</p>
            <input class="auth__field js-auth-name" type="text" placeholder="Имя" value="">
            <p class="error-field js-error-name"></p>
        </div>
    `;
};

export const password = () => {
    return `
        <div class="auth__password">
            <p class="auth__text">Пароль</p>
            <input class="auth__field js-auth-password" type="password" placeholder="Пароль" value="">
            <p class="error-field js-error-password"></p>
        </div>
    `;
};
