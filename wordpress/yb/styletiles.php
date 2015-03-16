<?php global $ybwp_data; ?>

<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php echo get_bloginfo('name'); ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="http://www.ybdevel.com/dev/css/styletiles.css" media="screen, projection" rel="stylesheet" type="text/css" />

		<!--[if lte IE 7]>
			<link href="/wp-content/themes/yb/assets/styles/styletiles/css/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
		<![endif]-->

	</head>

	<body>
		<div id="top-bar">
			<span class="company-name"><?php echo get_bloginfo('name'); ?> Style Tiles</span><br>
			<span class="option-name">Option <span class="option-letter">A</span></span>
			<a href="/dev" id="back-to-project">Back to Project Links</a>
		</div>

		<div id="prev-button" class="side-controls"></div>
		<div id="next-button" class="side-controls"></div>

		<div id="style-viewer" class="">
			<?php echo iframeTiles($ybwp_data['opt-text-styletilesnum'], range('a', 'z')); ?>
		</div> <!-- end #wrapper -->

		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="http://www.ybdevel.com/dev/js/scripts.js"></script>
		<!-- Prompt IE 6 users to install Chrome Frame. -->
		<!--[if lt IE 7 ]>
			<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
			<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->
	</body>
</html>