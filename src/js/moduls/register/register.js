import {addError} from "../utils";
import {validate} from "../auth/validate";
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
			.then(function (response) {
				const {
					result,
					error
				} = response.data;
				if (result) {
					location.reload();
				}
				if (error) {
					addError(error, '.js-error-email');
					return;
				}
			})
			.catch(function (error) {
				location.reload();
			});
	}
};
