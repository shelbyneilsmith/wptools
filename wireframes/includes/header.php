<?php require_once("php/settings.php"); ?>
<?php require_once("php/library.php"); ?>

<!doctype html public "✰">
	<html class="no-js" lang="en">
    <head>
    	<meta charset="utf-8">
        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php if(strlen($page_title) > 0) {echo $page_title." | ";} ?><?php echo $site_title; ?></title>
        <!-- Mobile viewport optimized: j.mp/bplateviewport -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        
		<?php require_once("includes/styles.php"); ?>
		<?php require_once("includes/scripts.php"); ?>
    </head>
    
    <body class="<?php echo(formatString($page_title)); ?>">
		<div id="wrapper" class="hfeed clearfix">
			
		    <header>
		    	<div id="header-inner" class="clearfix">
	 			   <?php $heading_tag = $front ? 'h1' : 'div'; ?>
				   <!-- be sure to change the img src to actual path of logo image -->
				   <<?php echo $heading_tag; ?> id="site-title"><a href="./" title="<?php echo $company_name; ?>" rel="home"><?php echo $company_name; ?></a></<?php echo $heading_tag; ?>>
	               <nav class="main">
	                    <?php createNav($main_nav, true, false); ?>
	               </nav>
				</div>
			</header><!-- #header-->
		
		    <div id="main" class="clearfix">
