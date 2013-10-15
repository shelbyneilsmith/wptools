jQuery('html').removeClass('no-js').addClass('js');

$(function(){

	function classSwap(classOne, classTwo, target) {
		if ( $(target).hasClass(classOne) ) {
			$(target).removeClass(classOne).addClass(classTwo);
		}
		else if ( $(target).hasClass(classTwo) ) {
			$(target).removeClass(classTwo).addClass(classOne);
		}
		else {
			$(target).addClass(classOne);
		}
	}

	var menuButton = $('#menu-button, #menu-close'),
			menuWrapper = $('#container'),
			wrapper = $('#wrapper'),
			body = $('body'),
			html = $('html');

	menuButton.click(function() {
		classSwap('menu-open', 'menu-closed', html);
	});


});

(function () {

			/*
					1. Inject CSS which makes iframe invisible
			*/

		var div = document.createElement('div'),
				ref = document.getElementsByTagName('base')[0] ||
							document.getElementsByTagName('script')[0];

		div.innerHTML = '&shy;<style> iframe { visibility: hidden; } </style>';

		ref.parentNode.insertBefore(div, ref);

		/*
				2. When window loads, remove that CSS,
					 making iframe visible again
		*/

		window.onload = function() {
				div.parentNode.removeChild(div);
		}

})();