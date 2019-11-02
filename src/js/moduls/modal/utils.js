const defaultParam = () => {
	return {
		headerName: null,
		content: null,
		needBtnClose: null
	};
};

export const preparedParams = (params) => {
	const defaultParams = defaultParam();
	
	Object.keys(defaultParams).forEach((key) => {
		const param = params[key];
		if (typeof param !== 'undefined') {
			defaultParams[key] = param;
		}
	}, defaultParams);
	
	return defaultParams;
};
