const defaultParam = () => {
	return {
		headerName: null,
		content: null,
		needBtnClose: null,
		callbacks: {
			btnClose: null,
			btnSubmit: null
		},
	};
};

export const preparedParams = (params) => {
	const defaultParams = defaultParam();
	Object.keys(defaultParams).forEach((key) => {
		const param = params[key];
		if (
			typeof params.callbacks !== 'undefined' &&
			key === 'callbacks'
		) {
			Object.keys(defaultParams.callbacks).forEach(
				(keyCallBack) => {
					const param = params.callbacks[keyCallBack];
					if (typeof param !== 'undefined') {
						defaultParams.callbacks[key] = param;
					}
				}, defaultParams.callbacks
			);
		}
		if (typeof param !== 'undefined') {
			defaultParams[key] = param;
		}
	}, defaultParams);
	
	return defaultParams;
};
