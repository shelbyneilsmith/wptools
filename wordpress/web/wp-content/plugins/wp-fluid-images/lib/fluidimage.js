/**
 * Name: fluidimage.js
 *
 * @author       Pat Ramsey <pat@slash25.com>
 * @copyright    Copyright (c) 2012, Pat Ramsey
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @description  Part of the WP Fluid Images plugin. Replaces pixel-based width & height attributes with style attributes using percentages.
 *
 */

jQuery(document).ready(function($) {
	//run the function on the .hentry element ( covers both .post or .page )
	cleanImg('.hentry');

});

function cleanImg(el) {
	jQuery( el + ' img').each(function() {

		// get image width & height attributes
		var imgh = jQuery(this).attr('height');
		var imgw = jQuery(this).attr('width');
		//find width of the .hentry parent div
		var postw = jQuery(el).width();
		
		// Test for existence of .wp-caption
		if (jQuery(this).parent('.wp-caption').length > 0) {
			// Remove the width & height values from the image (img)
			jQuery(this).removeAttr('width').removeAttr('height');
			// Set capw to equal the width of the .wp-caption div
			var capw = jQuery('.wp-caption').width();
			// Remove the style attribute from .wp-caption
			jQuery('.wp-caption').removeAttr('style');
			// Calculate the width of .wp-caption as a percentage of the width of .hentry
			var caperc = ((capw / postw) * 100);
			// Write a style attribute with width as a percentage
			jQuery('.wp-caption').attr('style','width:' + caperc + '%;');
			
		} else {

			//Remove the width & height attributes. If the image width exceeds the .hentry container, set style attribute to width:100%
			if (imgw > postw) { 
				jQuery(this).removeAttr('width').removeAttr('height').attr('style','width="97%;');
			}
			
			//Remove the width & height attributes. If the image width is narrower than the width of the .hentry element, calculate the width of the image as a percentage of the width of .hentry, set style attribute to width:% If the image is part of a WordPress gallery, take the .gallery-icon element into account.

			var gal = jQuery(this).closest('.gallery-icon');
			var galw = jQuery(gal).width();

			if ( (imgw < postw) && jQuery(gal).length > 0 ) { 
//				jQuery(gal).css('background','red');
				var gperc = ((imgw / galw) * 100);
				
				jQuery(this).removeAttr('width').removeAttr('height').attr('style','width:' + gperc + '%;');
				
			} else {
				var nperc = ((imgw / postw) * 100);
				
				jQuery(this).removeAttr('width').removeAttr('height').attr('style','width:' + nperc + '%;');
			}
		}
	});
}
