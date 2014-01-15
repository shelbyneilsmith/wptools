		    </section><!-- #main -->
		</div> <!-- end #wrapper -->

		<footer class="site-footer">
			<div class="footer-inner">

				<?php wp_nav_menu( array('theme_location' => 'footer-nav', 'container' => 'nav', 'container_id' => 'main-nav-footer', 'container_class' => 'main-nav' )); ?>

				<div class="copyright">Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name') ?></div>

			</div>
		</footer> <!-- end site footer -->


		<!-- all js scripts are loaded in library/yb.php -->
		<?php wp_footer(); ?>

		<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
	       chromium.org/developers/how-tos/chrome-frame-getting-started -->
	    <!--[if lt IE 7 ]>
	        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	        <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	    <![endif]-->

	</body>

</html> <!-- end page. -->