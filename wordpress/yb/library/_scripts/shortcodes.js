var min_w = 1500; // minimum video width allowed
var video_width_original = 1280;  // original video dimensions
var video_height_original = 720;
var vid_ratio = 1280/720;

jQuery(document).ready(function($){

	/* ------------------------------------------------------------------------ */
	/* Accordion */
	/* ------------------------------------------------------------------------ */

	$('.accordion').each(function(){
		var acc = $(this).attr("rel") * 2;
		$(this).find('.accordion-inner:nth-child(' + acc + ')').show();
		$(this).find('.accordion-inner:nth-child(' + acc + ')').prev().addClass("active");
	});

	$('.accordion .accordion-title').click(function() {
		if($(this).next().is(':hidden')) {
			$(this).parent().find('.accordion-title').removeClass('active').next().slideUp(200);
			$(this).toggleClass('active').next().slideDown(200);
		}
		return false;
	});

	/* ------------------------------------------------------------------------ */
	/* Alert Messages */
	/* ------------------------------------------------------------------------ */

	$(".alert-message .close").click(function(){
		$(this).parent().animate({'opacity' : '0'}, 300).slideUp(300);
		return false;
	});

	/* ------------------------------------------------------------------------ */
	/* Skillbar */
	/* ------------------------------------------------------------------------ */

	$('.skillbar').each(function(){
		dataperc = $(this).attr('data-perc'),
		$(this).find('.skill-percentage').animate({ "width" : dataperc + "%"}, dataperc*20);
	});

	/* ------------------------------------------------------------------------ */
	/* Tabs */
	/* ------------------------------------------------------------------------ */

	$('div.tabset').tabset();

	/* ------------------------------------------------------------------------ */
	/* Toggle */
	/* ------------------------------------------------------------------------ */

	if( $(".toggle .toggle-title").hasClass('active') ){
		$(".toggle .toggle-title.active").closest('.toggle').find('.toggle-inner').show();
	}

	$(".toggle .toggle-title").click(function(){
		if( $(this).hasClass('active') ){
			$(this).removeClass("active").closest('.toggle').find('.toggle-inner').slideUp(200);
		}
		else{
			$(this).addClass("active").closest('.toggle').find('.toggle-inner').slideDown(200);
		}
	});

	/* ------------------------------------------------------------------------ */
	/* Video Background
	/* ------------------------------------------------------------------------ */

	vid_w_orig = parseInt($('video').attr('width'), 10);
	vid_h_orig = parseInt($('video').attr('height'), 10);

	$(window).resize(function () { resizeToCover(); });
	$(window).trigger('resize');

	function resizeToCover() {

		$('.videosection .video-wrap').each(function(i){

			var $sectionWidth = $(this).closest('.videosection').outerWidth();
			var $sectionHeight = $(this).closest('.videosection').outerHeight();

			$(this).width($sectionWidth);
			$(this).height($sectionHeight);

			// calculate scale ratio
			var scale_h = $sectionWidth / video_width_original;
			var scale_v = $sectionHeight / video_height_original;
			var scale = scale_h > scale_v ? scale_h : scale_v;

			// limit minimum width
			min_w = vid_ratio * ($sectionHeight+20);

			if (scale * video_width_original < min_w) {scale = min_w / video_width_original;}

			$(this).find('video, .mejs-overlay, .mejs-poster').width(Math.ceil(scale * video_width_original +2));
			$(this).find('video, .mejs-overlay, .mejs-poster').height(Math.ceil(scale * video_height_original +2));

			$(this).scrollLeft(($(this).find('video').width() - $sectionWidth) / 2);

			$(this).find('.mejs-overlay, .mejs-poster').scrollTop(($(this).find('video').height() - ($sectionHeight)) / 2);
			$(this).scrollTop(($(this).find('video').height() - ($sectionHeight)) / 2);

		});

	} // end resizetocover

/* EOF document.ready */
});

/* Tabset Function ---------------------------------- */
(function ($) {
	$.fn.tabset = function () {
		var $tabsets = $(this);
		$tabsets.each(function (i) {
			var $tabs = $('li.tab a', this);
			$tabs.click(function (e) {
				var $this = $(this);
				panels = $.map($tabs, function (val, i) {
					return $(val).attr('href');
				});
				$(panels.join(',')).hide();
				$tabs.removeClass('selected');
				$this.addClass('selected').blur();
				$($this.attr('href')).show();
				e.preventDefault();
				return false;
			}).first().triggerHandler('click');
		});
	};
})(jQuery);

/* ------------------------------------------------------------------------ */
/* EOF */
/* ------------------------------------------------------------------------ */