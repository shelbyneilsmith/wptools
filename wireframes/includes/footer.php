		    </div><!-- #main -->
			<footer class="footer" role="contentinfo">
			
				<div id="footer-inner" class="wrap clearfix">
					
					<nav role="navigation" class="footer-nav">
                    	<?php createNav($footer_nav, false, true); ?>
	                </nav>
	             					
                <div class="copyright">Copyright &copy; <?php echo ($year_created); echo ((date("Y") > $year_created) ? '-' . date("Y") : ""); ?> <?php echo $company_name; ?></div>
				
				</div> <!-- end #inner-footer -->
				
			</footer> <!-- end footer -->
		
		</div> <!-- end #container -->
        <?php include("includes/footer_scripts.php"); ?>
    </body>
</html>
