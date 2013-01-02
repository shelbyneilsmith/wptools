jQuery(document).ready(function($) {
   var allPanels = $('.mcm_faq dd').hide('fast');
   $('.mcm_faq dt a').click(function(e) {
	 e.preventDefault();
	$target = $(this).parent().next();
	if(!$target.hasClass('active')){
		allPanels.removeClass('active').slideUp('fast');
		$target.addClass('active').slideDown('fast');
	} 
     return false;
   });
});