			</div><!-- #main -->
			<footer class="footer" role="contentinfo">

				<div id="footer-inner" class="wrap clearfix">

					<nav role="navigation" class="footer-nav">
						<?php createNav($footer_nav, false, true); ?>
					</nav>

					<div class="copyright">Copyright &copy; <?php echo date('Y'); ?> <?php echo $company_name; ?></div>

				</div> <!-- end #inner-footer -->

			</footer> <!-- end footer -->
		</div> <!-- end #wrapper -->

		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<script src="//code.jquery.com/jquery-latest.min.js"></script>
		<script>window.jQuery || document.write('<script src="../libs/jquery-1.10.2.min.js">\x3C/script>')</script>
		<script type="text/javascript" src="../libs/yb_library.js"></script>
		<script type="text/javascript" src="library/js/scripts.js"></script>

		<?php include("rw_controls.php"); ?>

		<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
		chromium.org/developers/how-tos/chrome-frame-getting-started -->
		<!--[if lt IE 7 ]>
		<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
		<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->
	</body>
</html>