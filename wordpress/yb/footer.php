			<?php global $ybwp_data; ?>

			<?php
				if ( !empty($ybwp_data['opt-layout']) && !empty($ybwp_data['opt-homelayout']) ) {
					if ( ( $ybwp_data['opt-layout'] === "Full Width" ) || ( $ybwp_data['opt-homelayout'] === "Full Width" ) ) {
						$full_width_class = "full-width";
					} else {
						$full_width_class = "";
					}
				}
			?>

			<footer id="footer" class="site-footer">
				<div class="container <?php echo $full_width_class; ?>">
					<?php if( !empty($ybwp_data['opt-checkbox-footerwidgets'] ) ) { ?>
						<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widgets')); ?>
					<?php } ?>

					<?php if ( !empty($ybwp_data['opt-checkbox-footernav'] ) ) : ?>
						<?php wp_nav_menu( array('theme_location' => 'footer-nav', 'container' => 'nav', 'container_id' => 'site-footer-nav', 'container_class' => 'footer-nav' )); ?>
					<?php endif; ?>
				</div>
				<div id="copyright" class="clearfix">
					<div class="container <?php echo $full_width_class; ?>">

						<div class="copyright-text">
							<?php if( !empty($ybwp_data['opt-textarea-copyright'] )) { ?>
								<?php echo $ybwp_data['opt-textarea-copyright']; ?>
							<?php } else { ?>
								Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name') ?>
							<?php } ?>
						</div>

						<?php if( !empty($ybwp_data['opt-checkbox-socialfooter']) && outputSocialIcons() ) { ?>
							<div class="social-icons clearfix">
								<ul>
									<?php echo outputSocialIcons(); ?>
								</ul>
							</div>
						<?php } ?>

						<?php if ( !empty($ybwp_data['opt-checkbox-backtotop'] ) ) : ?>
							<div id="back-to-top"><a href="#"><?php _e( 'Back to Top', 'yb' ) ?></a></div>
						<?php endif; ?>
					</div>
				</div><!-- end copyright -->
			</footer>

		</div><!-- end #wrapper -->
		<?php if( !empty($ybwp_data['opt-textarea-analyticscode'])) { echo $ybwp_data['opt-textarea-analyticscode']; } ?>

		<?php wp_footer(); ?>

		<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
		chromium.org/developers/how-tos/chrome-frame-getting-started -->
		<!--[if lt IE 7 ]>
			<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
			<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->
	</body>
</html> <!-- end page. -->