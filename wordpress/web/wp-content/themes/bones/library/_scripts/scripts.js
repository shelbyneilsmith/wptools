(function($){
		
	$.getScript("/wp-content/themes/bones/library/_scripts/libs/yb_library.js", function() {
		//do yb library function calls here!
		//////available functions:////////
				
				//* flickrFeed_user_all(user_id, section_id, count) - adds a flickr feed to specified section, with lightbox effects added
				
				//* flickrFeed_set(user_id, set_id, section_id, count) - adds a flickr feed to specified section, with lightbox effects added
		
				//* validateForm(formSelector) - enables front-end validation for selected form
						
				//* makeSlider(parentElement, slide_effect, speed, pause, control) - creates slideshow using nivo slider plugin. 
				
				//* menuIntent(sens, int, slideSpeed, mouseOutTimeOut) - uses hover intent plugin to control navigation drop down menus. all arguments are optional. int, slideSpeed and mouseOutTimeOut are in milliseconds (1000 = 1 second);
		
				//* function rwdSlider(element)
				
				//* function inputMask(element, maskPattern, placeHolder);
				
	});
	
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
	
	//placeholder fix
		//$.Placeholder.init();
	//end placeholder fix
	//placeholders for select elements
	$('select').each(function(){
		$(this).change(function() {
			if($(this).val() == "0") $(this).addClass("empty");
			else $(this).removeClass("empty");
		});
		$(this).change();
	});
	//end placeholders for select elements
	
})( jQuery );

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

/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
*/
(function(w){
	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && navigator.userAgent.indexOf( "AppleWebKit" ) > -1 ) ){ return; }
    var doc = w.document;
    if( !doc.querySelector ){ return; }
    var meta = doc.querySelector( "meta[name=viewport]" ),
        initialContent = meta && meta.getAttribute( "content" ),
        disabledZoom = initialContent + ",maximum-scale=1",
        enabledZoom = initialContent + ",maximum-scale=10",
        enabled = true,
		x, y, z, aig;
    if( !meta ){ return; }
    function restoreZoom(){
        meta.setAttribute( "content", enabledZoom );
        enabled = true; }
    function disableZoom(){
        meta.setAttribute( "content", disabledZoom );
        enabled = false; }
    function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );
		// If portrait orientation and in one of the danger zones
        if( !w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){ disableZoom(); } }
		else if( !enabled ){ restoreZoom(); } }
	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );
})( this );