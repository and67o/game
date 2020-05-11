import * as axios from "axios";

export function socialAuth(event) {
	const $this = event.currentTarget;
	const socialNetworkId = $this.dataset.socialNetwork;
	const dataForAxios = {
		url: 'socialAuth/authorisation',
		data: {
			socialNetwork: socialNetworkId,
			returnUrl: '/'
		}
	};
	
	axios
		.post(
			dataForAxios.url,
			dataForAxios.data
		)
		.then((response) => {
			console.log(response.data.linkContinue)
			window.location = response.data.linkContinue;
		})
		// .catch((response) => {
		// 	console.log(response);
		// });
}