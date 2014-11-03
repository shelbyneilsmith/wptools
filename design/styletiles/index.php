<?php
require_once("../settings.php");
require_once("../libs/library.php");
?>

<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php echo $company_name; ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="library/css/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />

		<!--[if lte IE 7]>
			<link href="stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
		<![endif]-->

	</head>

	<body>
		<div id="top-bar">
			<span class="company-name"><?php echo $company_name; ?> Style Tiles</span><br>
			<span class="option-name">Option <span class="option-letter">A</span></span>
			<a href="/design/" id="back-to-project">Back to Project Links</a>
		</div>

		<div id="prev-button" class="side-controls"></div>
		<div id="next-button" class="side-controls"></div>

		<div id="style-viewer" class="">
			<?php echo iframeTiles($styleTiles, range('a', 'z')); ?>
		</div> <!-- end #wrapper -->

	<script src="../libs/jquery-1.10.2.min.js"></script>
	<script src="library/js/scripts.js"></script>
	<!-- Prompt IE 6 users to install Chrome Frame. -->
	<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
	</body>
</html>