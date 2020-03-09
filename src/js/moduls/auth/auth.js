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
			.then( ({data : { errors, result, data }} = response) => {
				console.log(data,!result,  errors);
				//TODO Проверить размер объекта
				if (!result && error) {
					addError(errors.default, '.js-error-default');
				} else {
					console.log(errors, result, data);
				}
			})
			.catch(function (error) {
				console.log(21,error);
			});
	}
};
