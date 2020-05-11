const ApiService = {
	init () {
		axios.defaults.baseURL = API_URL
	},
	
	setHeader () {
		axios.defaults.headers.common = {
			'X-Requested-With': 'XMLHttpRequest',
		}
	},
	
	get (resource, slug = '') {
		return Vue.axios
			.get(`${resource}/${slug}`)
			.catch(error => {
				throw new Error(`ERROR: ${error}`)
			})
	},
	
	post (resource, params) {
		return Vue.axios.post(`${resource}`, params)
	}
}

export default ApiService