<?php

require_once("../settings.php");
require_once("../libs/library.php");

// Determine page title
if ($page_title === "" ) {
	$pageTitle = $company_name;
}
else {
	$pageTitle = $page_title . " | " . $company_name;
}

// Determine site title element
if ($front = 1) {
	$headingTag = 'h1';
}
else {
	$headingTag = 'div';
}

// Format the page title for use as class
$pageClass = formatString($page_title);

?>

<!doctype html>
	<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>
			<?php echo $pageTitle; ?>
		</title>

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="library/css/screen.css">
		<!--[if lte IE 8]>
			<link href="library/css/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
		<![endif]-->
	</head>

	<body class="<?php echo $pageClass; ?>">
		<div id="media-query"> </div>
		<div id="wrapper" class="hfeed clearfix">

			<header>
				<div id="header-inner" class="clearfix">
					<?php echo "<" . $headingTag . " id='site-title'>" ?>
						<a href="./" title="<?php echo $company_name; ?>" rel="home">
							<?php echo $company_name; ?>
						</a>
					<?php echo "</" . $headingTag . ">" ?>

					<nav class="main">
						<?php createNav($main_nav, true, false); ?>
					</nav>
				</div>
			</header><!-- #header-->

			<div id="main" class="clearfix">
