jQuery('html').removeClass('no-js').addClass('js');

$(function(){

	var styleViewer = $('#style-viewer');

	var nextButton = $('#next-button');
	var prevButton = $('#prev-button');

	var totalTiles = $('.style-tile-iframe').length - 1;
	var currentTile = 0;

	var tileName = $('.option-name');
	var tileLetter = $('.option-letter');

	var alphabet = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

	function updateLetter() {
		tileName.addClass('option-anim-hidden');
		setTimeout( function() {

			tileLetter.html( alphabet[currentTile] );
			tileName.removeClass('option-anim-hidden');

		}, 1000);
	}

	nextButton.click(function() {
		if (currentTile < totalTiles) {
			var currentPos = currentTile * 100;
			var newPos = ((currentTile + 1) * 100) * -1;
			var newPosPercentage = newPos + "%";
			currentTile += 1;
			styleViewer.css('left', newPosPercentage);
		}

		else if (currentTile == totalTiles) {
			currentTile = 0;
			styleViewer.css('left', 0);
		}

		updateLetter();
	});


	prevButton.click(function() {
		if (currentTile > 0) {
			currentPos = currentTile * 100;
			newPos = ((currentTile - 1) * 100) * -1;
			newPosPercentage = newPos + "%";
			currentTile -= 1;
			styleViewer.css('left', newPosPercentage);

			console.log(newPos);
			console.log(newPosPercentage);
		}

		else if (currentTile == 0) {
			currentTile = totalTiles;
			newPos = (totalTiles * 100) * -1;
			newPosPercentage = newPos + "%";
			styleViewer.css('left', newPosPercentage);
		}

		updateLetter();
	});

});