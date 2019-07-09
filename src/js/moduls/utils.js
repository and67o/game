/**
 * Fire function Asynchonosly
 *
 * @param {Array} functionsArr - array of fired functions
 * @param {number} timeout - Fimeout before fire
 */
export const fireAsync = (functionsArr, timeout = 0) => {
	return functionsArr.forEach(
		element => setTimeout(element, timeout)
	);
};
