import './../scss/base.scss';
import './../scss/mainPage.scss';

const $createNewGame = $('.js-create-new-game');

$createNewGame.on('click', (event) => {
	event.preventDefault();
	const dataForAfax = {
		url: 'Game/createGame',
		type: 'POST',
		dataType: 'json',
	};
	$.ajax(dataForAfax)
		.done((response) => {
			if (response) {
				location.href = 'GameField';
			} else {
				console.log('some trouble');
			}
		})
		.fail(() => {

		});
});