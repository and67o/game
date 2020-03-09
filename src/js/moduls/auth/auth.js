import {
	validate
} from "./validate";
import * as axios from "axios";
import {
	addError
} from "../utils";

export const authorisation = () => {
	const
		email = $('.js-email').val(),
		password = $('.js-password').val(),
		error = validate(email, password);

	if (error) {
		const dataForAxios = {
			url: 'auth/authorisation',
			data: {
				email: email,
				password: password
			}
		};
		
		axios
			.post(
				dataForAxios.url,
				dataForAxios.data
			)
			.then(({data : { errors, result, data }} = response) => {
				console.log( errors, result, data)
				if (!result && Object.keys(errors).length) {
					addError(errors.default, '.js-error-default');
				} else if (result) {
					location.reload();
				}
			})
			.catch( ({data : { errors }} = response) => {
				console.log(errors);
			});
	}
};
