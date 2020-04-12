import {
	SOCIAL_BTNS
} from "./constants";

let btns = '';

Object.keys(SOCIAL_BTNS).map((btn) => {
	btns += `
		<li
			class="js-social-btn ${SOCIAL_BTNS[btn]['imageClass']} social__btn"
			id="${SOCIAL_BTNS[btn]['name']}"
			data-social-network="${SOCIAL_BTNS[btn]['socialNetwork']}">
		</li>
	`;
});

export const socialBtn = () => {
	return `
		<ul class="social">
			${btns}
		</ul>
	`;
};
