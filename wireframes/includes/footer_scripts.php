<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lte IE 6]>
	<script type="text/javascript" src="js/supersleight-min.js"></script>
<![endif]-->

<?php if ($hover_intent): ?>
	<script type="text/javascript" src="js/jquery.hoverIntent.minified.js"></script>
<?php endif; ?>
<?php if ($lightbox): ?>
	<script type="text/javascript" src="js/jquery.lightbox-0.5.min.js"></script>
<?php endif; ?>
<?php if ($galleria): ?>
	<script type="text/javascript" src="js/galleria/galleria-1.2.6.min.js"></script>
<?php endif; ?>
<?php if ($bxslider): ?>
	<script type="text/javascript" src="js/jquery.bxSlider.min.js"></script>
<?php endif; ?>

<?php if($slider): ?>
	<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
<?php endif; ?>

<script src="js/jquery.placeholder.js"></script>
<script src="js/mylibs/yb_library.js"></script>
<script src="js/scripts.js"></script>

<script language="Javascript">
	$(function() {
	<?php if ($hover_intent): ?>
		menuIntent();
	<?php endif; ?>
	<?php if ($lightbox): ?>
		$("a[rel*=lightbox]").lightBox();
	<?php endif; ?>
	})
</script>

<!-- twitter feed script -->
<?php if ($twitter_feed): ?>
	<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
	<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $twitter_user; ?>.json?callback=twitterCallback2&amp;count=<?php echo $twitter_count; ?>"></script>
<?php endif; ?>

<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->