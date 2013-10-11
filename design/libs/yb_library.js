//////available functions:////////

		//* inputPlaceholder(elementSelector) - enables placeholder text on specified input fields for non-html5
		
		//* flickrFeed_user_all(user_id, section_id, count) - adds a flickr feed to specified section, with lightbox effects added
		
		//* flickrFeed_set(user_id, set_id, section_id, count) - adds a flickr feed to specified section, with lightbox effects added

		//* validateForm(formSelector) - enables front-end validation for selected form
		
		//* dynamicCufon(elementSelector, hover_on, font_family) - cufon replacement for elements generated dynamically. font_family variable is optional.
		
		//* makeSlider(parentElement, slide_effect, speed, pause, control) - creates slideshow using nivo slider plugin. 
		
		//* menuIntent(sens, int, slideSpeed, mouseOutTimeOut) - uses hover intent plugin to control navigation drop down menus. all arguments are optional. int, slideSpeed and mouseOutTimeOut are in milliseconds (1000 = 1 second);

		//* function rwdSlider(element)
		
		//* function inputMask(element, maskPattern, placeHolder);
		
		//* function offScreenMenu(menuID, returnAfter, menuDirection, mobileBool, mobileBreak);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

////////enables placeholder text on specified input fields for non-html5.////////
//	jQuery.support.placeholder = false;
//	test = document.createElement('input');
//	if('placeholder' in test) jQuery.support.placeholder = true;
function inputPlacehoder(elementSelector){	
	if(!$.support.placeholder) { 
		var active = document.activeElement;
		$(elementSelector+':text').focus(function () {
			if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
				$(this).val('').removeClass('hasPlaceholder');
			}
		}).blur(function () {
			if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
				$(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
			}
		});
		$(elementSelector+':text').blur();
		$(active).focus();
		$('form').submit(function () {
			$(this).find('.hasPlaceholder').each(function() { $(this).val(''); });
		});
	}
}

////////create flickr feed, with lightbox effects/////////
function flickrFeed_user_all(user_id, section_id, count){
	var itemNum = 0;
	$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?id="+user_id+"&lang=en-us&format=json&jsoncallback=?", function(data){
	  $.each(data.items, function(i,item){
		var thumbImage = item.media.m;
		var largeImage = thumbImage.replace('_m.jpg', '.jpg');
		$("<img/>").attr("src", thumbImage).appendTo(section_id)
		  .wrap("<a href='" + largeImage + "' title='" + item.title + "'></a>").parent('a').lightBox();
		itemNum++;
		if(itemNum == count) {
			return false;
		}
	  });
	});
}

////////create flickr feed from individual set, with lightbox effects/////////
function flickrFeed_set(user_id, set_id, section_id, count){
	var itemNum = 0;
	$.getJSON("http://api.flickr.com/services/feeds/photoset.gne?set="+set_id+"&nsid="+user_id+"&lang=en-us&format=json&jsoncallback=?", function(data){
	  $.each(data.items, function(i,item){
		var thumbImage = item.media.m;
		var largeImage = thumbImage.replace('_m.jpg', '.jpg');
		$("<img/>").attr("src", thumbImage).appendTo(section_id)
			 .wrap("<a href='" + largeImage + "' title='" + item.title + "'></a>").parent('a').lightBox();
			itemNum++;
			if(itemNum == count) {
				return false;
			}
	  });
	});
}

////////add lightbox ability to images///////
function makeLightbox(selector){
		$(selector+" a").attr('rel', 'lightbox');
}

///////form validation////////
jQuery.fn.exists = function(){return jQuery(this).length>0;}
function validateForm(formSelector){
	if($(formSelector).exists())
	{
		$(formSelector).validate();
	}
}

////////dynamic element cufon replacement////////
function cufonReplace(elementSelector, hover_on, font_family){
	if(font_family) {
		Cufon.replace(elementSelector, {fontFamily: font_family, hover: hover_on});
	} else {
		Cufon.replace(elementSelector, {hover: hover_on});
	} 
}


////////creates slideshow using nivo slider plugin///////
function makeSlider(parentElement, slide_effect, speed, pause, control, start){
	$(parentElement+' img').hide();
	$(window).load(function(){
	// feature box
		var total = $(parentElement+' img').length;
		var rand = Math.floor(Math.random()*total);
		$(parentElement).nivoSlider({
			effect: slide_effect, //sliceDown, sliceDownLeft, sliceUp, sliceUpLeft, sliceUpDown, sliceUpDownLeft, fold, fade, random, slideInRight, slideInLeft, boxRandom, boxRain, boxRainReverse, boxRainGrow, boxRainGrowReverse
			slices:15,
			animSpeed:speed, //slide transition speed, in milliseconds
			pauseTime:pause, //how long each slide will show, in milliseconds
			startSlide:start, //Set starting Slide (0 index)
			directionNav:false, //Next & Prev
			directionNavHide:true, //Only show on hover
			controlNav: (control == "num" || control == "thumbs" || control == "rel") ? true : false, //1,2,3...
			controlNavThumbs: (control == "thumbs") ? true : false, //Use thumbnails for Control Nav
			controlNavThumbsFromRel: (control == "rel") ? true : false, //Use image rel for thumbs
			controlNavThumbsSearch: '.jpg', //Replace this with...
			controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
			keyboardNav:true, //Use left & right arrows
			pauseOnHover:true, //Stop animation while hovering
			manualAdvance:false, //Force manual transitions
			captionOpacity:0.8, //Universal caption opacity
			beforeChange: function(){},
			afterChange: function(){},
			slideshowEnd: function(){} //Triggers after all slides have been shown
		});
	});
}

/////////uses galleria plugin to make simple image slider
function makeGalleria(parentElement, width, height) {
	$(window).load(function() {
		Galleria.loadTheme('/js/galleria/themes/classic/galleria.classic.min.js');
		$(parentElement).galleria({
			width: width,
			height: height
		});
		$(parentElement + " img").show()
	});
}


////////uses hover intent plugin to control navigation drop down menus////////
function menuIntent(sens, interval, slideSpeed, mouseOutTimeOut) {
	if(!sens) {
		var sens = 5;
	}
	if(!interval) {
		var interval = 100;
	}
	if(!slideSpeed) {
		var slideSpeed = 200;
	}
	if(!mouseOutTimeOut) {
		var mouseOutTimeOut = 300;
	}
	var menuConfig = {    
		sensitivity: sens, // number = sensitivity threshold (must be 1 or higher)    
		interval: interval, // number = milliseconds for onMouseOver polling interval    
		over: function()
		{
			$(this).children('ul').slideDown(slideSpeed);
		}, // function = onMouseOver callback (REQUIRED)    
		timeout: mouseOutTimeOut, // number = milliseconds delay before onMouseOut    
		out: function()
		{
			$(this).children('ul').slideUp(slideSpeed);
		} // function = onMouseOut callback (REQUIRED)    
	};				
	$('.dropMenu ul').hide();
	$('.dropMenu').hoverIntent(menuConfig);
}

function rwdSlider(element) {
	$(window).load(function(){
		$(element).flexslider({
			animation: "fade",              //String: Select your animation type, "fade" or "slide"
			slideDirection: "horizontal",   //String: Select the sliding direction, "horizontal" or "vertical"
			slideshow: true,                //Boolean: Animate slider automatically
			slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
			animationDuration: 600,         //Integer: Set the speed of animations, in milliseconds
			directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
			controlNav: true,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
			keyboardNav: true,              //Boolean: Allow slider navigating via keyboard left/right keys
			mousewheel: false,              //Boolean: Allow slider navigating via mousewheel
			prevText: "Previous",           //String: Set the text for the "previous" directionNav item
			nextText: "Next",               //String: Set the text for the "next" directionNav item
			pausePlay: false,               //Boolean: Create pause/play dynamic element
			pauseText: 'Pause',             //String: Set the text for the "pause" pausePlay item
			playText: 'Play',               //String: Set the text for the "play" pausePlay item
			randomize: false,               //Boolean: Randomize slide order
			slideToStart: 0,                //Integer: The slide that the slider should start on. Array notation (0 = first slide)
			animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
			pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
			pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
			controlsContainer: "",          //Selector: Declare which container the navigation elements should be appended too. Default container is the flexSlider element. Example use would be ".flexslider-container", "#container", etc. If the given element is not found, the default action will be taken.
			manualControls: "",             //Selector: Declare custom control navigation. Example would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
			start: function(){},            //Callback: function(slider) - Fires when the slider loads the first slide
			before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
			after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
			end: function(){}               //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
		});
	});
}

function inputMask(element, maskPattern, placeHolder) {
	placeHolder = typeof placeHolder !== 'undefined' ? placeHolder : "_";
	$(element).mask(maskPattern, {placeholder: placeHolder});
}


function offScreenMenu(menuID, returnAfter, menuDirection, mobileBool, mobileBreak) {
	$(window).load(function() {
		var menuObj = $(menuID);
		var initBool = true;
		var menuOffset;
		
		if ((menuDirection == "top") || (menuDirection == "bottom")) {
			menuOffset = menuObj.outerHeight();
		} else if ((menuDirection == "left") || (menuDirection == "right")) {
			menuOffset = menuObj.outerWidth();
		}

		function initMenu(menuState) {

			var menuPosNeg = "";			
			
			if(menuState == "on") {
			
				menuObj.children('a.menuLink').show();
								
				var menuOnCSS = { 
					position: 'absolute', 
					zIndex: '9999'
				};
				menuObj.prependTo('body').wrap('<div id="menuWrap" />');
				$('#menuWrap').css(menuOnCSS).css(menuDirection, 0);

				$('<a class="menuLink" href="#"><span></span>Menu</a>').appendTo('#menuWrap').click(menuClick);
		
				$("<div id='dark-overlay'></div>").appendTo('body').css({
					position: "fixed",
					display: "none",
					top: "0px",
					left: "0px",
					width: "100%",
					height: "100%",
					background: "rgba(0,0,0,.75)"
				});
				
				initBool = false;
				
				menuObj.hide();
			} else if (menuState == "off") {
			
				var menuOffCSS = { 
					position: 'relative'
				};
				menuObj.insertAfter(returnAfter).show();
				
				$('#menuWrap').remove();
				$("#dark-overlay").remove();
				
				initBool = true;
			}
			
		}
		
		function menuClick() {
			if (menuObj.css('display') == 'none') {
				menuObj.show();
				var newMenuOffset = "-" + menuOffset + "px";;

				$('#menuWrap').css(menuDirection, newMenuOffset).css('position', 'fixed');
			}
			var menuAnim = parseInt($('#menuWrap').css(menuDirection),10) == 0 ? -menuOffset : 0;
						
			var anim = {opacity: 1};

			anim[menuDirection] = menuAnim;
			$('#menuWrap').animate(anim, 400, function() {
				if (!parseInt($('#menuWrap').css(menuDirection),10) == 0) {
					menuObj.hide();
					$('#menuWrap').css(menuDirection, 0).css('position', 'absolute');
				}
			});
			$('#dark-overlay').fadeToggle();

		    return false;
		}

		if (mobileBool) {
		
			initBool = false;
			
			if ($(window).width() < mobileBreak) {
				initBool = true;
			}
			
			$(window).resize(function() {
				if ($(window).width() < mobileBreak) {
					if (initBool) {
						initMenu("on");
					}
				} else if ($(window).width() >= mobileBreak)	{
					initMenu("off");
				}
				
			});
		}
		
		if (initBool) {
			initMenu("on");
		}
	});
}

// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  if(this.console) {
   arguments.callee = arguments.callee.caller;
   var newarr = [].slice.call(arguments);
   (typeof console.log === 'object' ? log.apply.call(console.log, console, newarr) : console.log.apply(console, newarr));
  }
};
// make it safe to use console.log always
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,timeStamp,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();){b[a]=b[a]||c}})((function(){try
{console.log();return window.console;}catch(err){return window.console={};}})());