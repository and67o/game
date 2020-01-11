import {
	validate
} from "./validate";
import * as axios from "axios";

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
			.then(function (response) {
				const {
					result,
				} = response.data;
			})
			.catch(function (error) {
				console.log(error);
			});
	}
};
