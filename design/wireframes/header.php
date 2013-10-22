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

	<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0" />

	<link rel="stylesheet" href="library/css/screen.css">
</head>

<body>
	<div id="container">

	<div id="wrapper">

		<header>
			<div id="header-inner">
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
