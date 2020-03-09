import {
	addError
} from "../utils";
import {
	validate
} from "../auth/validate";
import * as axios from "axios";

export const registerNewPerson = () => {
	const email = $('.js-email').val();
	const password = $('.js-password').val();
	const name = $('.js-name').val();

	const error = validate(email, password);

	if (error) {
		const dataForAxios = {
			url: 'Register/register',
			data: {
				email: email,
				password: password,
				name: name,
			}
		};
		axios
			.post(
				dataForAxios.url,
				dataForAxios.data
			)
			.then( ({data : { errors, result, data }} = response) => {
				if (result) {
					location.reload();
				}
				if (errors) {
					
					Object.keys(errors).forEach((errorName) => {
						addError(errors[errorName], '.js-error-' + errorName);
					}, errors);
				}
			})
			.catch(function() {
				location.reload();
			});
	}
};
