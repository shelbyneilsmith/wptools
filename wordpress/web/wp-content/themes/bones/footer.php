		    </div><!-- #main -->
		</div> <!-- end #wrapper -->
			
		<footer class="footer" role="contentinfo">
		
			<div id="footer-inner" class="wrap clearfix">
				
				<nav id="footer-navigation" role="navigation" class="footer-nav">
					<?php bones_footer_links(); ?>
                </nav>
             					
		        <div class="copyright">Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name') ?> <!--| 315 Beech Bend Rd. Bowling Green, KY | <strong>270.799.0323</strong>--></div>
			
			</div> <!-- end #inner-footer -->
			
		</footer> <!-- end footer -->
		
		
		<!-- all js scripts are loaded in library/bones.php -->
		<?php wp_footer(); ?>
		<?php //echo "<script src='".WP_CONTENT_URL."/themes/bones/library/_scripts/jquery.maskedinput-1.3.min.js'></script>"; ?>
		<?php //echo "<script src='".WP_CONTENT_URL."/themes/bones/library/_scripts/jquery.placeholder.1.3.min.js'></script>"; ?>
		
		<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
	       chromium.org/developers/how-tos/chrome-frame-getting-started -->
	    <!--[if lt IE 7 ]>
	        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	        <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	    <![endif]-->

	</body>

</html> <!-- end page. what a ride! -->