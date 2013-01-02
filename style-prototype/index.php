<?php require_once("php/settings.php"); ?>
<?php require_once("php/library.php"); ?>

<!doctype html public "?">
<!--[if lt IE 7]> <html class="no-js ie ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!--[if IE 10]>    <html class="no-js ie10" lang="en"> <![endif]-->
<!--[if gt IE 10]><!--><html class="no-js" lang="en"><!--<![endif]-->
    <head>
    	<meta charset="utf-8">
        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $site_title; ?></title>
        <!-- Mobile viewport optimized: j.mp/bplateviewport -->
		<?php if ($responsive): ?><meta name="viewport" content="width=device-width, initial-scale=1.0"><?php endif; ?>
        
		<link href="stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
		<!--[if IE]>
		   <link href="stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
		<![endif]-->
		<?php if ($lightbox): ?>
			<link rel="stylesheet" href="stylesheets/jquery.lightbox-0.5.css" />
		<?php endif; ?>
		<?php if ($responsive && $slider): ?>
			<link rel="stylesheet" href="stylesheets/flexslider.css" />
		<?php endif; ?>
		<?php if(!$responsive && $slider): ?>
			<link rel="stylesheet" href="stylesheets/nivo-slider.css" />
		<?php endif; ?>
		
		<!--[if IE]>
		<style type="text/css">
		  .clearfix {
		    zoom: 1;     /* triggers hasLayout */
		    display: block;     /* resets display for IE/Win */
		    }  /* Only IE can see inside the conditional comment
		    and read this CSS rule. Don't ever use a normal HTML
		    comment inside the CC or it will close prematurely. */
		</style>
		<![endif]-->		
		
		<script src="//lesscss.googlecode.com/files/less-1.0.18.min.js"></script>
		<?php if ($jquery): ?>
			<script src="//code.jquery.com/jquery-latest.min.js"></script>
			<script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js">\x3C/script>')</script>
		    <!--[if (gte IE 6)&(lte IE 8)]>
		      <script type="text/javascript" src="/js/libs/selectivizr-min.js"></script>
		      <noscript><link rel="stylesheet" href="[fallback css]" /></noscript>
		    <![endif]-->
		<?php endif; ?>
		<?php if($responsive): ?>
			<script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>
		    <script src="js/respond.min.js"></script>
		<?php endif; ?>
		<!--[if lt IE 9]>
		    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			<script>window.jQuery || document.write('<script src="js/libs/html5.js">\x3C/script>')</script>
		<![endif]-->
		<!--[if lt IE 9]>
			<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js">IE7_PNG_SUFFIX=".png";</script>
			<script>window.jQuery || document.write('<script src="js/libs/IE9.js">\x3C/script>')</script>
		<![endif]-->
    </head>
    
    <body>
        <div id="wrapper" class="hfeed clearfix">
		    <header>
		    	<div id="header-inner" class="clearfix">
				   <!-- be sure to change the img src to actual path of logo image -->
				   <h1 id="site-title"><a href="/" title="<?php echo $company_name; ?>" rel="home"><img src="images/mainLogo.png" alt="<?php echo $company_name; ?>" /></a></h1>
	               <!--<nav class="main">
	               </nav>-->
				</div>
			</header><!-- #header-->
		
			<div id="container">
				<div id="content" class="content-box">
					<h2>Page Header</h2>
					<h3>Subheader</h3>
			    	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin eu mi sapien. Nunc nec enim eu odio ornare volutpat consequat ut arcu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut vulputate euismod justo, sagittis blandit urna gravida quis. In hac habitasse platea dictumst. Proin pharetra condimentum ipsum vel luctus. Quisque eget mauris nec odio bibendum fermentum sed ut nunc.</p>
			    	<p><a href="#">Sample link text &raquo;</a></p>
				</div>
				
				<ul id="color-palette">
					<h3>Color Palette</h3>
					<li class="color-1"><span>#ffffff</span></li>
					<li class="color-2"><span>#eeeeee</span></li>
					<li class="color-3"><span>#dddddd</span></li>
					<li class="color-4"><span>#cccccc</span></li>
					<li class="color-5"><span>#bbbbbb</span></li>
				</ul>
				
	        	<form id="modular-form" class="modular-box">
	        		<h3>Modular/Form Box</h3>
	        		<ul class="form-fields">
	        			<li>
	        				<label for="name">Name:</label>
	        				<input type="text" name="name" />
	        			</li>
	        			<li>
	        				<label for="email">Email:</label>
	        				<input type="text" name="email" />
	        			</li>
	        			<li>
	        				<label for="message">Message:</label>
	        				<textarea type="text" name="messsage"></textarea>
	        			</li>
	        			<li>
	        				<input type="submit" class="submit-btn" value="Submit" />
	        			</li>
	        		</ul>
	        	</form>
	        	
	        	<div id="other-styles">
		        	<div class="texture-box">
		        	</div>
		        	<div class="texture-box">
		        	</div>
		        	<div class="texture-box">
		        	</div>
	        	</div>
			</div> <!-- end #container -->
		</div> <!-- end #wrapper -->
		
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
		<?php if (!$responsive && $slider): ?>
			<script type="text/javascript" src="js/jquery.nivo.slider.pack.js"></script>
		<?php endif; ?>
		<?php if ($galleria): ?>
			<script type="text/javascript" src="js/galleria/galleria-1.2.6.min.js"></script>
		<?php endif; ?>
		<?php if ($bxslider): ?>
			<script type="text/javascript" src="js/jquery.bxSlider.min.js"></script>
		<?php endif; ?>
		
		<?php if($responsive && $slider): ?>
			<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
		<?php endif; ?>
		
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
		
		<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
		       chromium.org/developers/how-tos/chrome-frame-getting-started -->
		  <!--[if lt IE 7 ]>
		    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
		    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		  <![endif]-->
      </body>
</html>