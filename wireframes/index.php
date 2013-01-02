<?php 
	//page settings

	$page_title = ""; //most of the time, this will stay empty for the front page of the site.
	$front = 1;
?>

<?php require_once("includes/header.php"); ?>

	<div id="container">
		
        <div id="content" class="wrap clearfix">
	        <?php if(strlen($page_title) > 0) {echo "<h2>$page_title</h2>";} ?>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin eu mi sapien. Nunc nec enim eu odio ornare volutpat consequat ut arcu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut vulputate euismod justo, sagittis blandit urna gravida quis. In hac habitasse platea dictumst. Proin pharetra condimentum ipsum vel luctus. Quisque eget mauris nec odio bibendum fermentum sed ut nunc. Duis malesuada, libero quis porttitor eleifend, tellus odio ullamcorper quam, tincidunt ullamcorper est est molestie ante. Aenean quis fermentum dui. Suspendisse interdum sagittis sodales. Suspendisse mauris nunc, egestas a vestibulum vel, venenatis egestas leo. Duis pellentesque convallis ipsum vitae aliquam.</p>
		</div> <!-- end #content -->

	</div> <!-- end #container -->
    
<?php require_once("includes/footer.php"); ?>