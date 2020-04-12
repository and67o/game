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
		.then(({data: {linkContinue}} = response) => {
			window.location = linkContinue;
		})
		.catch((response) => {
			console.log(response);
		});
}