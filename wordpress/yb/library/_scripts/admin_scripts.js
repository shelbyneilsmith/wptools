
(function($){
	//set conditional position state for admin nav
	var setResponsive = function () {
		//Is the window taller than the #adminmenuwrap by 50px or more?
		if ($(window).height() > $("#adminmenuwrap").height() + 50) {
			// ...if so, make yhe #adminmenuwrap fixed
			$('#adminmenuwrap').css('position', 'fixed');
		} else {
			//...otherwise, leave it relative
			$('#adminmenuwrap').css('position', 'relative');
		}
	}
	$(window).resize(setResponsive);
	setResponsive();
	
})( jQuery );
  
